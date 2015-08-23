<?php
/**
 * SocialConnect project
 * @author: Patsura Dmitry @ovr <talk@dmtry.me>
 */

namespace SocialConnect\Vk\Exception;

use SocialConnect\Common\Http\Response;
use SocialConnect\Vk\Exception;

class ServerError extends Exception
{
    /**
     * @var Response
     */
    public $response;

    /**
     * @param Response $response
     */
    public function __construct(Response $response)
    {
        $this->response = $response;

        parent::__construct('Server Error', $code = 0, null);
    }
}
