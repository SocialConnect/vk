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
                    return $json->response[0];
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

        }

        return false;
    }
}
