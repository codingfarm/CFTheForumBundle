<?php

namespace CF\TheForumBundle\Tests\Services;

use CF\TheForumBundle\Services\Permissions;
use DateTime;

class PermissionsTest extends \PHPUnit_Framework_TestCase
{
    /** @var Permissions */
    private $permissionsService;

    protected function setUp()
    {
        $this->permissionsService = new Permissions();
    }


    public function testIsAllowEdit()
    {
        $user = $this->createUser(1, array('USER'));

        $post = $this->createPost($user, new DateTime("now"));

        $this->assertEquals(1, $user->getId());
        $this->assertTrue($this->permissionsService->isAllowEdit($post, $user));

        $postExpired = $this->createPost($user,new DateTime("-20min"));

        $this->assertFalse($this->permissionsService->isAllowEdit($postExpired, $user),'expired don\'t allow editing');

        $user2 = $this->createUser(2, array('USER'));

        $this->assertFalse($this->permissionsService->isAllowEdit($post, $user2));

        $user3 = $this->createUser(2, array('ROLE_FORUM_MODERATOR', "USER"));

        $this->assertTrue($this->permissionsService->isAllowEdit($post, $user3));
    }

    public function createPost($user, $createDate)
    {
        $post = $this->getMock('CF\TheForumBundle\Model\Post');
        $post->expects($this->any())
            ->method('getAuthor')
            ->will($this->returnValue($user));

        $post->expects($this->any())
            ->method('getCreatedDate')
            ->will($this->returnValue($createDate));

        return $post;
    }

    public function createUser($id, array $roles)
    {
        $user = $this->getMock('FOS\UserBundle\Model\User');

        $user->expects($this->any())
            ->method('getId')
            ->will($this->returnValue($id));

        $user->expects($this->any())
            ->method('getRoles')
            ->will($this->returnValue($roles));

        return $user;
    }
}