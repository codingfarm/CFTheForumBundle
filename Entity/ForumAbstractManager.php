<?php

namespace CF\TheForumBundle\Entity;


use CF\TheForumBundle\Model\GeneralManagerInterface;
use Doctrine\ORM\Mapping\ClassMetadata;
use Doctrine\ORM\EntityManager;

abstract class ForumAbstractManager implements GeneralManagerInterface
{
    /** @var string */
    protected $class;

    /** @var \Doctrine\ORM\EntityManager */
    protected $entityManager;

    /** @var \Doctrine\ORM\EntityRepository */
    protected $repository;
    protected $meta;

    public function __construct($class, EntityManager $entityManager)
    {
        $this->class = $class;
        $this->entityManager = $entityManager;
        $this->repository = $entityManager->getRepository($this->class);
        $this->meta = new ClassMetadata($this->class);
    }

    public function findById($id)
    {
        return $this->repository->find($id);
    }

    public function findBy($params)
    {
        return $this->repository->findBy($params);
    }

    public function create()
    {
        return new $this->class;
    }

    public function getList()
    {
        return $this->repository->createQueryBuilder('o')->getQuery()->getResult();
    }


    public function persist($object, $andFlush = true)
    {
        $this->entityManager->persist($object);
        if ($andFlush) {
            $this->entityManager->flush();
        }
    }

    public function flush()
    {
        $this->entityManager->flush();
    }

}