<?php
/*
 * This file is part of the CF TheForumBundle
 */

namespace CF\TheForumBundle\Entity;

use CF\TheForumBundle\Model\PostManagerInterface;
use CF\TheForumBundle\Model\TopicInterface;
use Doctrine\ORM\EntityManager;
use CF\TheForumBundle\Model\PostInterface;

class PostManager extends ForumAbstractManager implements PostManagerInterface
{
    public function createPost()
    {
        return new $this->class;
    }

    public function getTopicPostsAsTree($topicId, $withDeleted = false, $withOutFirst = true)
    {

        $treeStruct = array();
        $postsLine  = array();
        $posts      = $this->getTopicPosts($topicId, $withDeleted);
        /** @var $post PostInterface */
        foreach ($posts as $post) {
            if (!isset($postsLine[$post->getId()])) {
                $postsLine[$post->getId()] = array('post'=> $post, 'children'=> array());
            }

            if ($post->getReplyPost() === null) {
                $treeStruct[] = &$postsLine[$post->getId()];
            } else {
                $postsLine[$post->getReplyPost()->getId()]['children'][] = &$postsLine[$post->getId()];
            }
        }

        return $treeStruct;
    }

    public function getTopicPosts($topicId, $withDeleted = false, $withOutFirst = true)
    {
        if ($topicId instanceof TopicInterface) {
            $topicId = $topicId->getId();
        }

        $qb = $this->getTopicPostsQueryBuilder($topicId, $withDeleted, $withOutFirst);

        return $qb->getQuery()->getResult();
    }


    public function getTopicPostsQueryBuilder($topicId, $withDeleted, $withOutFirst)
    {
        $qb = $this->repository->createQueryBuilder('p')
            ->join('p.author', 'u')
            ->andWhere('p.topic = :topic_id')
            ->setParameter('topic_id', $topicId)
            ->orderBy('p.createdDate', 'ASC');

        if ($withOutFirst) {
            $qb->join('p.topic', 't')
                ->andWhere('t.firstPost != p');
//            $qb->setFirstResult(1);
//            $qb->setMaxResults(PHP_INT_MAX / 2);
        }

        if (!$withDeleted) {
            $qb->andWhere('p.isDeleted=false');
        }

        return $qb;
    }


    public function getLastPost($topicId)
    {
        $qb = $this->repository->createQueryBuilder('p')
            ->join('p.author', 'u')
            ->andWhere('p.topic = :topic_id')
            ->setParameter('topic_id', $topicId)
            ->orderBy('p.createdDate', 'DESC')
            ->andWhere('p.isDeleted=false')
            ->andWhere('p.isBlocked=false')
            ->setMaxResults(1);

        return $qb->getQuery()->getOneOrNullResult();
    }


    public function fetchAuthorsStatFromPosts(array $listOfPosts)
    {
        $stat = array();
        foreach ($listOfPosts as $post) {
            if (!isset($stat[$post->getAuthor()->getId()])) {
                $stat[$post->getAuthor()->getId()] = array('author'=> $post->getAuthor(), 'count'=> 1);
            } else {
                $stat[$post->getAuthor()->getId()]['count']++;
            }
        }

        return array_values($stat);
    }

}