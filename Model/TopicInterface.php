<?php
/*
 * This file is part of the CF TheForumBundle
 */

namespace CF\TheForumBundle\Model;

use Symfony\Component\Security\Core\User\UserInterface as UserInterface;

/**
 * TopicInterface.
 *
 * Any post to be used by CF\TheForumBundle must implement this interface.
 *
 * @author Studenikin Sergey <studenikin.s@gmail.com>
 */
interface TopicInterface
{

    /**
     * get id
     */
    public function getId();

    /**
     * Set time of topic's creating
     *
     * @param DateTime $createdDate
     */
    public function setCreatedDate($createdDate);

    /**
     *  Gets the time of topic's creating
     *
     * @return DateTime
     */
    public function getCreatedDate();

    /**
     * Set the time of topic's updating
     *
     * @param DateTime $updatedDate
     */
    public function setUpdatedDate($updatedDate);

    /**
     *  Gets the time of topic's updating
     *
     * @return DateTime
     */
    public function getUpdatedDate();

    /**
     * Set the category for the topic
     *
     * @param CategoryInterface $category
     */
    public function setCategory(CategoryInterface $category);

    /**
     * Return the category for the topic
     *
     * @return CategoryInterface
     */
    public function getCategory();

    /**
     * Set link to the first post (message) of the topic
     *
     * @param PostInterface $post
     */
    public function setFirstPost(PostInterface $post);

    /**
     * Return the first post(message) of the topic
     *
     * @return \CF\TheForumBundle\Model\PostInterface
     */
    public function getFirstPost();

    /**
     * Set the title of the topic
     *
     * @param string $name
     */
    public function setName($name);

    /**
     * Return the title of the topic
     *
     * @return string
     */
    public function getName();

    /**
     * Return the deleted flag
     *
     * @return boolean
     */
    public function isDeleted();

    /**
     * Get the author of the topic
     *
     * @return UserInterface
     */
    public function getAuthor();

    /**
     * Get the count of posts in the topic
     *
     * @return integer
     */
    public function getCountPosts();

    /**
     * Set the count of posts in the topic
     *
     * @param integer $value
     */
    public function setCountPosts($value);

    /**
     * @param PostInterface $post
     */
    public function setLastPost(PostInterface $post);

    /**
     * @return PostInterface
     */
    public function getLastPost();
}