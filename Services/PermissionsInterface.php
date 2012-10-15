<?php
/*
 * This file is part of the CF TheForumBundle
 */


namespace CF\TheForumBundle\Services;

use Symfony\Component\Security\Core\User\UserInterface;

/**
 * Service for checking of possibility to edit, delete posts, topics etc by current user.
 *
 * @author Studenikin Sergey <studenikin.s@gmail.com>
 */
interface PermissionsInterface
{

    /**
     * Check the user. If it's the post's owner or a moderator then return true, else return false.
     *
     * @param \CF\TheForumBundle\Model\PostInterface $post
     * @param $user
     */
    public function isAllowEdit(\CF\TheForumBundle\Model\PostInterface $post, $user);

    /**
     * @param \Symfony\Component\Security\Core\User\UserInterface $user
     * @param string $role Role name
     * @return Boolean
     */
    public function hasUserRole(UserInterface $user, $role);

}
