<?php
/*
 * This file is part of the CF TheForumBundle
 */

namespace CF\TheForumBundle\Model;

use CF\TheForumBundle\Model\CategoryInterface as CategoryInterface;
use Symfony\Component\Security\Core\User\UserInterface as UserInterface;
use DateTime;

/**
 * Storage agnostic post object
 *
 * @author Studenikin Sergey <studenikin.s@gmail.com>
 */
abstract class Category implements CategoryInterface
{
    function __toString()
    {
        return $this->getName();
    }
}