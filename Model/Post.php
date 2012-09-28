<?php
/*
 * This file is part of the CF TheForumBundle
 */

namespace CF\TheForumBundle\Model;

use CF\TheForumBundle\Model\PostInterface as PostInterface;
use Symfony\Component\Security\Core\User\UserInterface as UserInterface;
use DateTime;

/**
 * Storage agnostic post object
 *
 * @author Studenikin Sergey <studenikin.s@gmail.com>
 */
abstract class Post implements PostInterface
{

    /**
     * @var CF\TheForumBundle\Entity\Topic
     */
    protected $topic = null;

    /**
     * @var CF\TheForumBundle\Entity\Post
     */
    protected $replyPost;

    /**
     * @var UserInterface
     */
    protected $author;


    public function __construct()
    {
        $this->setCreatedDate(new DateTime("now"));
    }

    /**
     * Get the topic
     *
     * @return \CF\TheForumBundle\Entity\Topic
     */
    public function getTopic()
    {
        return $this->topic;
    }

    /**
     * Get replyPost
     *
     * @return \CF\TheForumBundle\Entity\Post
     */
    public function getReplyPost()
    {
        return $this->replyPost;
    }

}