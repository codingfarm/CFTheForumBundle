<?php
/*
 * This file is part of the CF TheForumBundle
 */
namespace CF\TheForumBundle\Model;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\User\UserInterface;

interface TopicManagerInterface extends GeneralManagerInterface
{

    /**
     * Create an empty topic's type object
     *
     * @return \CF\TheForumBundle\Model\TopicInterface
     */
    public function createTopic();

    /**
     * Save the post with a link to the topic
     *
     * @param TopicInterface $topic
     * @param PostInterface $post
     * @param \Symfony\Component\Security\Core\User\UserInterface $author
     * @param \Symfony\Component\HttpFoundation\Request $request
     */
    public function addPostToTopic(TopicInterface $topic, PostInterface $post, UserInterface $author, Request $request);

    /**
     * Update the topic's fields
     *
     * @param TopicInterface $topic
     * @param PostInterface $first_post - the message of the topic
     * @param \Symfony\Component\Security\Core\User\UserInterface $author
     * @param \Symfony\Component\HttpFoundation\Request $request
     */
    public function saveNewTopic(TopicInterface $topic, PostInterface $first_post, UserInterface $author, Request $request);

    /**
     * @return \Pagerfanta\Pagerfanta
     */
    public function getTopicsPager($categorySlug = '', $maxPerPage);
}