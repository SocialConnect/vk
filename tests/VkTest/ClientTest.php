<?php
/**
 * SocialConnect project
 * @author: Patsura Dmitry @ovr <talk@dmtry.me>
 */

namespace VkTest;

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

    public function testGetUserWrongId()
    {
        $this->setExpectedException('SocialConnect\Vk\Exception', 'Invalid user id');

        $client = $this->getClient();
        $result = $client->getUser(-1);
    }

    public function testIsGroupMemberSuccess()
    {
        $client = $this->getClient();

        $this->assertTrue($client->isGroupMember(1, 1));
        $this->assertTrue($client->isGroupMember(45934290, 103061163));

        $this->assertFalse($client->isGroupMember(10639516, 103061163)); //MDK
    }

    public function testGetFriends()
    {
        $client = $this->getClient();

        $friends = $client->getFriendsList(103061163);
        $this->assertInternalType('array', $friends->items);
        $this->assertTrue(count($friends) > 0);
    }
}
