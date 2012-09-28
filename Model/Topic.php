<?php
/*
 * This file is part of the CF TheForumBundle
 */

namespace CF\TheForumBundle\Model;

use DateTime;

/**
 * Storage agnostic post object
 *
 * @author Studenikin Sergey <studenikin.s@gmail.com>
 */
abstract class Topic implements TopicInterface
{
    /**
     * @var CategoryInterface
     */
    protected $category;

    /**
     * @var PostInterface
     */
    protected $firstPost;
    /**
     * @var PostInterface
     */
    protected $lastPost;

    /**
     * @return bool
     */
    public function isDeleted()
    {
        return $this->firstPost->getIsDeleted();
    }

    /**
     * @return \Symfony\Component\Security\Core\User\UserInterface
     */
    public function getAuthor()
    {
        return $this->firstPost->getAuthor();
    }

    /**
     * @return \CF\TheForumBundle\Model\PostInterface
     */
    public function getLastPost()
    {
        return $this->lastPost;
    }

    /**
     * @param \CF\TheForumBundle\Model\PostInterface $lastPost
     */
    public function setLastPost(PostInterface $lastPost)
    {
        $this->lastPost = $lastPost;
    }
}