<?php
/**
 * Created by PhpStorm.
 * User: ovr
 * Date: 8/29/14
 * Time: 9:12 PM
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
