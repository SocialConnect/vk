<?php
/**
 * SocialConnect project
 * @author: Patsura Dmitry @ovr <talk@dmtry.me>
 */

namespace SocialConnect\Vk;

class Client
{
    /**
     * Application secret
     *
     * @var string|integer
     */
    protected $appId;

    /**
     * Application secret
     *
     * @var string
     */
    protected $appSecret;

    /**
     * @var \Guzzle\Http\Client
     */
    protected $httpClient;

    /**
     * @var array
     */
    protected $baseParameters = array(
        'v' => 5.24
    );

    /**
     * @var string
     */
    protected $accessToken;

    /**
     * @return string
     */
    public function getAccessToken()
    {
        return $this->accessToken;
    }

    /**
     * @param string $accessToken
     */
    public function setAccessToken($accessToken)
    {
        $this->accessToken = $accessToken;
    }

    /**
     * @param string|integer $appId
     * @param string $appSecret
     */
    public function __construct($appId, $appSecret)
    {
        $this->appId = $appId;
        $this->appSecret = $appSecret;

        $this->httpClient = new \Guzzle\Http\Client('https://api.vk.com/');
    }

    /**
     * @var \SocialConnect\Common\Hydrator\ObjectMap|null
     */
    protected $hydrator;

    /**
     * @return \SocialConnect\Common\Hydrator\ObjectMap
     */
    public function getHydrator()
    {
        if (!$this->hydrator) {
            return $this->hydrator = new \SocialConnect\Common\Hydrator\ObjectMap(array(
                'id' => 'id',
                'first_name' => 'firstname',
                'last_name' => 'lastname'
            ));
        }

        return $this->hydrator;
    }
    
    /**
     * Request social server api
     *
     * @param $uri
     * @param array $parameters
     * @return bool
     * @throws Exception
     */
    public function request($uri, array $parameters = array())
    {
        $parameters = array_merge($this->baseParameters, $parameters);

        $request = $this->httpClient->get($uri.'?'.http_build_query($parameters));
        $response = $request->send();

        if ($response) {
            if ($response->isServerError()) {
                throw new Exception('Server error');
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
                throw new Exception('Error 2');
            }
        }

        return false;
    }

    /**
     * @link http://vk.com/dev/users.get
     *
     * @param $id
     * @return bool
     */
    public function getUser($id)
    {
        $result = $this->request('method/getProfiles', array(
            'user_id' => $id
        ));

        if ($result) {
            $result = $result[0];

            return $this->getHydrator()->hydrate(new Entity\User(), $result);
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

        return $this->hydrateUsersCollection($apiResult);
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
     * @param $apiResult
     * @return array|bool
     */
    protected function hydrateUsersCollection($apiResult)
    {
        if ($apiResult && is_array($apiResult)) {
            $result = array();

            foreach ($apiResult as $row) {
                $result[] = $this->getHydrator()->hydrate(new Entity\User(), $result);
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
        return boolval($this->request('method/groups.isMember', array(
            'group_id' => $groupId,
            'user_id' => $id
        )));
    }

    /**
     * @param integer|string $groupId
     * @param array $ids
     * @return bool
     * @throws Exception
     */
    public function isGroupMembers($groupId, array $ids)
    {
        return boolval($this->request('method/groups.isMember', array(
            'group_id' => $groupId,
            'user_ids' => $ids
        )));
    }
}
