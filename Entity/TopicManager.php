<?php
/*
 * This file is part of the CF TheForumBundle
 */
namespace CF\TheForumBundle\Entity;

use CF\TheForumBundle\Model\TopicManagerInterface;
use Pagerfanta\Adapter\DoctrineORMAdapter;
use CF\TheForumBundle\Model\PostManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManager;
use DateTime;
use CF\TheForumBundle\Model\PostInterface;
use CF\TheForumBundle\Model\TopicInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Pagerfanta\Pagerfanta;

class TopicManager extends ForumAbstractManager implements TopicManagerInterface
{
    private $postManager;

    public function __construct($class, EntityManager $entityManager, PostManagerInterface $postManager)
    {
        parent::__construct($class, $entityManager);
        $this->postManager = $postManager;
    }

    /**
     * @return \CF\TheForumBundle\Model\TopicInterface
     */
    public function createTopic()
    {
        return new $this->class;
    }


    public function getLastTopics($categorySlug = "", $withDeleted = false)
    {
        return $this->findTopicsQueryBuilder($categorySlug, $withDeleted)->getQuery()->getResult();
    }

    public function findTopicsQueryBuilder($categorySlug = '', $withDeleted = false)
    {
        $qb = $this->repository->createQueryBuilder('t');
        $qb->join('t.firstPost', 'p');
        $qb->orderBy('t.updatedDate', 'desc');

        if (!$withDeleted) {
            $qb->andWhere('p.isDeleted=false');
        }

        if ('' != $categorySlug) {
            $qb->join('t.category', 'c')
                ->andWhere('c.slug = :slug')
                ->setParameter('slug', $categorySlug);
        }

        return $qb;
    }

    /**
     * Add a post to a topic
     * this method persists entity state to your storage
     *
     * @param \CF\TheForumBundle\Model\TopicInterface $topic
     * @param \CF\TheForumBundle\Model\PostInterface $post
     */
    public function addPostToTopic(TopicInterface $topic, PostInterface $post, UserInterface $author, Request $request)
    {
        $post->setTopic($topic);
        $post->setAuthor($author);
        $post->setAuthorIp($request->getClientIp());
        $topic->setUpdatedDate($post->getCreatedDate());
        $topic->setLastPost($post);
//        $topic->addPost($post);
        $this->persist($topic, false);
        $this->entityManager->persist($post);
        $this->entityManager->flush();

        $this->entityManager->refresh($topic);
        $topic->setCountPosts(count($this->postManager->getTopicPosts($topic)), false, true);
        $this->persist($topic);
    }

    /**
     * This method persists entity state to your storage
     *
     * @param \CF\TheForumBundle\Model\TopicInterface $topic
     * @param \CF\TheForumBundle\Model\PostInterface $first_post
     * @param \Symfony\Component\Security\Core\User\UserInterface $author
     * @param \Symfony\Component\HttpFoundation\Request $request
     */
    public function saveNewTopic(TopicInterface $topic, PostInterface $first_post, UserInterface $author, Request $request)
    {
        $topic->setFirstPost($first_post);
        $this->addPostToTopic($topic, $first_post, $author, $request);
    }

    /**
     * @return Pagerfanta
     */
    public function getTopicsPager($categorySlug = '', $maxPerPage)
    {
        $adaptor = new DoctrineORMAdapter($this->findTopicsQueryBuilder($categorySlug));
        $pager   = new Pagerfanta($adaptor);
        $pager->setMaxPerPage($maxPerPage);

        return $pager;
    }


}