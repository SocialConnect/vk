<?php
/**
     * SocialConnect project
     * @author: Patsura Dmitry @ovr <talk@dmtry.me>
     */

namespace SocialConnect\Vk\Exception;

use SocialConnect\Vk\Exception;

class Unsupported extends Exception
{
    public function __construct($message = 'Unsupported functionality', $code = 0, \Exception $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
