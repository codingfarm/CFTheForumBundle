<?php
/*
 * This file is part of the CF TheForumBundle
 */

namespace CF\TheForumBundle\Services;

use CF\TheForumBundle\Services\PermissionsInterface;
use CF\TheForumBundle\Model\CategoryManagerInterface;
use CF\TheForumBundle\Model\CategoryInterface;
use DateTime;
use DateInterval;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * Service for checking of possibility to edit, delete posts, topics etc by current user.
 *
 * @author Studenikin Sergey <studenikin.s@gmail.com>
 */

abstract class Permissions implements PermissionsInterface
{

    private $categoryManager;

    public function __construct(CategoryManagerInterface $categoryManager)
    {
        $this->categoryManager = $categoryManager;
    }

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
        }

        if ($this->isModerator($user, $post->getTopic()->getCategory())) {
            return true;
        } elseif ($post->getAuthor()->getId() == $user->getId()) {
            // todo: fix hardcoded 10m expiration
            return $post->getCreatedDate()->diff(new DateTime('now'))->format('%i') < 10;
        }

        return false;
    }


    public function isModerator($user, CategoryInterface $category = null)
    {
        if (!($user instanceof UserInterface)) {
            return false;
        }

        if ($this->hasUserRole($user, 'ROLE_FORUM_MODERATOR')) {
            return true;
        }
        elseif ($category !== null and $this->hasUserRole($user, $this->categoryManager->getModeratorRoleNameByCategory($category))) {
            return true;
        }

        return false;
    }
}
