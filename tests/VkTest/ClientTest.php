<?php
/**
 * SocialConnect project
 * @author: Patsura Dmitry @ovr <talk@dmtry.me>
 */

namespace VkTest;

class ClientTest extends \PHPUnit_Framework_TestCase
{
    protected $skipAccessTokenTest = false;

    public function getTestUserId()
    {
        return getenv('testUserId');
    }

    public function getClient()
    {
        $client = new \SocialConnect\Vk\Client(intval(getenv('applicationId')), getenv('applicationSecret'));
        $client->setHttpClient(new \SocialConnect\Common\Http\Client\Curl());
        $client->setAccessToken(getenv('testUserAccessToken'));

        if (strlen(getenv('testUserAccessToken')) < 10) {
            $this->skipAccessTokenTest = true;
        }

        return $client;
    }

    public function testGetUserSuccess()
    {
        $client = $this->getClient();
        $result = $client->getUser($this->getTestUserId());

        $this->assertInstanceOf('SocialConnect\Vk\Entity\User', $result);

        $this->assertInternalType('int', $result->id);
        $this->assertInternalType('string', $result->firstname);
        $this->assertInternalType('string', $result->lastname);

        $client = $this->getClient();
        $result = $client->getUser($this->getTestUserId(), array('sex'));

        $this->assertInstanceOf('SocialConnect\Vk\Entity\User', $result);

        $this->assertInternalType('int', $result->id);
        $this->assertInternalType('string', $result->firstname);
        $this->assertInternalType('string', $result->lastname);
        $this->assertInternalType('int', $result->sex);

    }

    public function testGetUsersSuccess()
    {
        $client = $this->getClient();
        $result = $client->getUsers([$this->getTestUserId(), 1, 176058131, 256611307, 98093405]);

        $this->assertInstanceOf('SocialConnect\Vk\Response\Collection', $result);
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
        $this->assertTrue($client->isGroupMember(45934290, $this->getTestUserId()));

        $this->assertFalse($client->isGroupMember(10639516, $this->getTestUserId())); //MDK
    }

    public function testIsGroupMembersSuccess()
    {
        $client = $this->getClient();

        $result = $client->isGroupMembers(1, array($this->getTestUserId(), 1));
        $this->assertEquals(1, $result[0]->member);
        $this->assertEquals(1, $result[1]->member);

        $result = $client->isGroupMembers(10639516, array($this->getTestUserId(), 1));
        $this->assertEquals(0, $result[0]->member);
        $this->assertEquals(0, $result[1]->member);
    }

    public function testGetFriendsList()
    {
        $client = $this->getClient();

        $friends = $client->getFriendsList($this->getTestUserId());
        $this->assertInternalType('array', $friends->items);
        $this->assertTrue(count($friends) > 0);
    }

    public function testGetFriends()
    {
        $client = $this->getClient();

        $result = $client->getFriends($this->getTestUserId());
        $this->assertInstanceOf('SocialConnect\Vk\Response\Collection', $result);
    }

    public function testGetAudio()
    {
        $client = $this->getClient();

        if ($this->skipAccessTokenTest) {
            $this->markTestSkipped('Need AccessToken');
        }

        $result = $client->getAudio($this->getTestUserId());
        $this->assertInstanceOf('SocialConnect\Vk\Response\Collection', $result);
    }

    public function testGetStatusByUserId()
    {
        $client = $this->getClient();

        if ($this->skipAccessTokenTest) {
            $this->markTestSkipped('Need AccessToken');
        }

        $result = $client->getStatus($this->getTestUserId());
        $this->assertInternalType('string', $result);
    }

    public function testGetStatusBySelf()
    {
        $client = $this->getClient();

        if ($this->skipAccessTokenTest) {
            $this->markTestSkipped('Need AccessToken');
        }

        /**
         * Get self status
         */
        $result = $client->getStatus();
        $this->assertInternalType('string', $result);
    }
}
