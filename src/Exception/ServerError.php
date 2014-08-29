<?php
/**
 * SocialConnect project
 * @author: Patsura Dmitry @ovr <talk@dmtry.me>
 */

namespace SocialConnect\Vk\Exception;

use SocialConnect\Vk\Exception;

class ServerError extends Exception
{
    public $response;

    /**
     * @param string $response
     */
    public function __construct($response)
    {
        $this->response = $response;

        parent::__construct('Server Error', $code = 0, $previous);
    }
}
