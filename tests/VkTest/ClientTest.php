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

    public function testGetUserSuccess()
    {
        $client = $this->getClient();
        $result = $client->getUser(103061163);

        $this->assertInstanceOf('SocialConnect\Vk\Entity\User', $result);

        $this->assertInternalType('int', $result->id);
        $this->assertInternalType('string', $result->firstname);
        $this->assertInternalType('string', $result->lastname);
    }
}
