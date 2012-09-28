<?php
/*
 * This file is part of the CF TheForumBundle
 */

namespace CF\TheForumBundle\Services;

use CF\TheForumBundle\Services\PermissionsInterface;
use DateTime;
use DateInterval;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * Service for checking of possibility to edit, delete posts, topics etc by current user.
 *
 * @author Studenikin Sergey <studenikin.s@gmail.com>
 */

class Permissions implements PermissionsInterface
{

    /**
     * Check the user. If it's the post's owner or a moderator then return true, else return false.
     *
     * @param \CF\TheForumBundle\Model\PostInterface $post
     * @return bool
     */
    public function isAllowEdit(\CF\TheForumBundle\Model\PostInterface $post, $user)
    {
        if (!($user instanceof UserInterface)) {
            return false;
        } elseif ($this->isModerator($user)) {
            return true;
        } elseif ($post->getAuthor()->getId() == $user->getId()) {
            // todo: fix hardcoded 10m expiration
            return $post->getCreatedDate()->diff(new DateTime('now'))->format('%i') < 10;
        }

        return false;
    }

    public function hasUserRole(UserInterface $user, $role)
    {
        return in_array(strtoupper($role), $user->getRoles(), true);
    }

    public function isModerator($user)
    {
        return ($user instanceof UserInterface) && $this->hasUserRole($user, 'ROLE_FORUM_MODERATOR');
    }
}
