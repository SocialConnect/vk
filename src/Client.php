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

    protected $baseParameters = array(
        'v' => 5.24
    );

    public function __construct($appId, $appSecret)
    {
        $this->appId = $appId;
        $this->appSecret = $appSecret;



        $this->httpClient = new \Guzzle\Http\Client('https://api.vk.com/');
    }

    /**
     * @param $uri
     * @param array $parameters
     * @return bool
     */
    public function request($uri, array $parameters = array())
    {
        $request = $this->httpClient->get($uri.'?'.http_build_query($parameters));
        $response = $request->send();

        if ($response) {
            if ($response->isServerError()) {

            }

            $body = $response->getBody(true);
            if ($body) {
                $json = json_decode($body);

                if ($json->response) {
                    return $json->response;
                }
            }
        }

        return false;
    }

    /**
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
            
            $user = new Entity\User();
            $user->id = $result->uid;
            $user->firstname = $result->first_name;
            $user->lastname = $result->last_name;

            return $user;
        }

        return false;
    }

    public function getUsers(array $ids)
    {
        if (count($ids) == 0) {
            return false;
        }

        $apiResult = $this->request('method/getProfiles', array(
            'uids' => $ids
        ));

        $result = array();
        foreach ($apiResult as $row) {
            $user = new Entity\User();
            $user->id = $row->uid;
            $user->firstname = $row->first_name;
            $user->lastname = $row->last_name;

            $result[] = $user;
        }

        return $result;
    }
}
