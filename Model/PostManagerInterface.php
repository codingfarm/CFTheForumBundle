<?php

/*
 * This file is part of the CF TheForumBundle
 */

namespace CF\TheForumBundle\Model;

interface PostManagerInterface extends GeneralManagerInterface
{

    /**
     * Create an object Post
     *
     * @return \CF\TheForumBundle\Model\PostInterface
     */
    public function createPost();

    /**
     * @param $topic int|TopicInterface : topic_id or object
     * @return array
     */
    public function getTopicPosts($topic, $withDeleted = false, $withOutFirst = true);

    public function getTopicPostsAsTree($topic, $withDeleted = false, $withOutFirst = true);

    /**
     * @param array $listOfPosts
     * @return array like array(
     *      array('author'=>$userObj, 'count'=>1),....
     *  )
     */
    public function fetchAuthorsStatFromPosts(array $listOfPosts);
}