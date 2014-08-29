<?php
/**
 * SocialConnect project
 * @author: Patsura Dmitry @ovr <talk@dmtry.me>
 */

namespace SocialConnect\Vk;

class Client extends \SocialConnect\Common\ClientAbstract
{
    use Constants;

    /**
     * @var array
     */
    protected $baseParameters = array(
        'v' => 5.24
    );

    /**
     * @param string|integer $appId
     * @param string $appSecret
     */
    public function __construct($appId, $appSecret)
    {
        parent::__construct($appId, $appSecret);

        $this->httpClient = new \Guzzle\Http\Client('https://api.vk.com/');
    }

    /**
     * @param string $accessToken
     */
    public function setAccessToken($accessToken)
    {
        $this->accessToken = $accessToken;
    }

    /**
     * @return \SocialConnect\Common\Hydrator\CloneObjectMap
     */
    public function getHydrator($object)
    {
        /**
         * @todo Think more about cache hydrators in class property
         */

        return new \SocialConnect\Common\Hydrator\CloneObjectMap(array(
            'id' => 'id',
            'first_name' => 'firstname',
            'last_name' => 'lastname',
            'hidden' => 'hidden',
            'deactivated' => 'deactivated',
            'owner_id' => 'ownerId',
            //Audio
            'artist' => 'artist',
            'title' => 'title',
            'duration' => 'duration',
            'url' => 'url',
            'genre_id' => 'genreId',
            'lyrics_id' => 'lyricsId',
            'no_search' => 'noSearch',
            'album_id' => 'albumId'
        ), $object);
    }

    /**
     * Request social server api
     *
     * @param $uri
     * @param array $parameters
     * @param bool $accessToken
     * @return bool
     * @throws Exception
     */
    public function request($uri, array $parameters = array(), $accessToken = false)
    {
        if ($accessToken) {
            $this->baseParameters['access_token'] = $this->accessToken;
        }

        $parameters = array_merge($this->baseParameters, $parameters);

        $request = $this->httpClient->get($uri.'?'.http_build_query($parameters));
        $response = $request->send();

        if ($response) {
            if ($response->isServerError()) {
                throw new Exception\ServerError($response);
            }

            $body = $response->getBody(true);
            if ($body) {
                $json = json_decode($body);

                if (isset($json->response)) {
                    return $json->response;
                } else {
                    if (isset($json->error)) {
                        throw new Exception($json->error->error_msg, $json->error->error_code);
                    }   
                }
            } else {
                throw new Exception\ServerError($response);
            }
        }

        return false;
    }

    /**
     * @link http://vk.com/dev/users.get
     *
     * @param $id
     * @param array $fields
     * @return bool|object
     */
    public function getUser($id, array $fields = array('id', 'first_name', 'last_name'))
    {
        $parameters = array(
            'user_id' => $id
        );

        if ($fields != $this->USER_DEFAULT_FIELDS) {
            $parameters['fields'] = $fields;
        }

        $result = $this->request('method/getProfiles', $parameters);

        if ($result) {
            $result = $result[0];

            return $this->getHydrator(new Entity\User())->hydrate($result);
        }

        return false;
    }

    /**
     * @link http://vk.com/dev/users.get
     *
     * @param array $ids
     * @return array|bool
     * @throws Exception
     */
    public function getUsers(array $ids)
    {
        if (count($ids) == 0) {
            return false;
        }

        $apiResult = $this->request('method/getProfiles', array(
            'uids' => $ids
        ));

        return $this->hydrateCollection($apiResult, $this->getHydrator(new Entity\User()));
    }

    /**
     * @link http://vk.com/dev/friends.get
     *
     * @param null $id
     * @return array|bool
     * @throws Exception
     */
    public function getFriendsList($id = null)
    {
        return $this->request('method/friends.get', array(
            'user_id' => $id
        ));
    }

    /**
     * @link http://vk.com/dev/friends.get
     *
     * @param null $id
     * @param array $fields
     * @return bool|Response\Collection
     * @throws Exception
     */
    public function getFriends($id = null, array $fields = array('first_name', 'last_name'))
    {
        $result = $this->request('method/friends.get', array(
            'user_id' => $id,
            'fields' => $fields
        ));

        if ($result) {
            return new Response\Collection(
                $this->hydrateCollection($result->items, $this->getHydrator(new Entity\Friend())),
                $result->count,
                function() {}
            );
        }

        return false;
    }

    /**
     * @param $apiResult
     * @param $hydrator
     * @return array|bool
     */
    protected function hydrateCollection($apiResult, $hydrator)
    {
        if ($apiResult && is_array($apiResult)) {
            $result = array();

            foreach ($apiResult as $row) {
                $result[] = $hydrator->hydrate($row);
            }

            return $result;
        }

        return false;
    }

    /**
     * @param integer|string $groupId
     * @param integer|string $id
     * @return bool
     * @throws Exception
     */
    public function isGroupMember($groupId, $id)
    {
        return (boolean) $this->request('method/groups.isMember', array(
            'group_id' => $groupId,
            'user_id' => $id
        ));
    }

    /**
     * @param integer|string $groupId
     * @param array $ids
     * @return bool
     * @throws Exception
     */
    public function isGroupMembers($groupId, array $ids)
    {
        return $this->request('method/groups.isMember', array(
            'group_id' => $groupId,
            'user_ids' => $ids
        ));
    }

    /**
     * @link http://vk.com/dev/status.get
     *
     * @param null $id
     * @return bool
     * @throws Exception
     */
    public function getStatus($id = null)
    {
        if ($id) {
            return $this->request('method/status.get', array(
                'user_id' => $id
            ));
        }

        return $this->request('method/status.get', array(), true);
    }

    /**
     * @link http://vk.com/dev/audio.get
     *
     * @param $ownerId
     * @return bool|Response\Collection
     * @throws Exception
     */
    public function getAudio($ownerId)
    {
        $result = $this->request('method/audio.get', array(
            'owner_id' => $ownerId
        ), true);

        if ($result) {
            return new Response\Collection(
                $this->hydrateCollection($result->items, $this->getHydrator(new Entity\Audio())),
                $result->count,
                function() {}
            );
        }

        return false;
    }
}
