<?php
/*
 * This file is part of the CF TheForumBundle
 */

namespace CF\TheForumBundle\Model;

use Symfony\Component\Security\Core\User\UserInterface as UserInterface;
use DateTime;

/**
 * PostInterface.
 *
 * Any post to be used by CF\TheForumBundle must implement this interface.
 *
 * @author Studenikin Sergey <studenikin.s@gmail.com>
 */
interface PostInterface {

    /**
     * Gets the id
     *
     * @return integer
     */
    public function getId();

    /**
     * Set time of post's creating
     *
     * @param DateTime $createdDate
     */
    public function setCreatedDate(DateTime $createdDate);

    /**
     *  Gets the creation timestamp
     *
     * @return DateTime
     */
    public function getCreatedDate();

    /**
     * Set the message
     *
     * @param string $body
     */
    public function setBody($body);

    /**
     * Get the message of the post
     *
     * @return mixed
     */
    public function getBody();

    /**
     * Set current user's IP
     *
     * @param string $userIp eq '127.0.0.1'
     */
    public function setAuthorIp($ipAsString);

    /**
     * Get the IP of the user's post
     *
     * @param bool $asInt
     */
    public function getAuthorIp($asInt = false);

    /**
     * Set the topic of the post
     *
     * @param TopicInterface $topic
     */
    public function setTopic(TopicInterface $topic);

    /**
     * Get the topic of the post
     *
     * @return \CF\TheForumBundle\Model\TopicInterface
     */
    public function getTopic();

    /**
     * Set the reply post
     *
     * @param PostInterface $replyPost
     */
    public function setReplyPost(PostInterface $replyPost=null);

    /**
     * Return the reply post
     *
     * @return PostInterface
     */
    public function getReplyPost();

    /**
     * Set DateTime user's updating
     *
     * @param DateTime $userUpdatedDate
     */
    public function setAuthorUpdatedDate($userUpdatedDate);

    /**
     * Return DateTime of user's updating
     *
     * @return DateTime
     */
    public function getAuthorUpdatedDate();

    /**
     * Set DateTime of moderator's updating
     *
     * @param DateTime $moderatorUpdatedDate
     */
    public function setModeratorUpdatedDate($moderatorUpdatedDate);

    /**
     * Get DateTime of the latest moderator's updating
     *
     * @return DateTime
     */
    public function getModeratorUpdatedDate();

    /**
     * Sets the author of the Post
     *
     * param UserInterface $user
     */
    public function setAuthor(UserInterface $author);

    /**
     * Return the author of the Post
     *
     * @return UserInterface
     */
    public function getAuthor();

    /**
     * Defines whether the post is blocked or not
     *
     * @param Boolean $bool
     */
    public function setIsBlocked($bool);

    /**
     * Indicates whether the post is blocked or not
     *
     * @return boolean
     */
    public function getIsBlocked();

    /**
     * Sets the post deleted flag
     *
     * @param $bool boolean
     */
    public function setIsDeleted($bool);

    /**
     * Return the post deleted flag
     *
     * @return Boolean
     */
    public function getIsDeleted();

}