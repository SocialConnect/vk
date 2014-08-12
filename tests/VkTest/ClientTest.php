<?php
/**
 * SocialConnect project
 * @author: Patsura Dmitry @ovr <talk@dmtry.me>
 */

class ClientTest extends \PHPUnit_Framework_TestCase
{
    public function getClient()
    {
        return new \SocialConnect\Vk\Client(4500322, 'applicationsecret');
    }
}
