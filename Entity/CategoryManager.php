<?php
/*
 * This file is part of the CF TheForumBundle
 */

namespace CF\TheForumBundle\Entity;

use CF\TheForumBundle\Model\CategoryManagerInterface;
use Doctrine\ORM\EntityManager;

class CategoryManager extends ForumAbstractManager implements CategoryManagerInterface
{

    public function findBySlug($slug)
    {
        return $this->repository->findOneBy(array('slug'=>$slug));
    }


}