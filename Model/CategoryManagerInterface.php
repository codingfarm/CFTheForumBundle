<?php

/*
 * This file is part of the CF TheForumBundle
 */
namespace CF\TheForumBundle\Model;

/**
 * CategoryManagerInterface.
 *
 * Interface for working with a database.
 *
 * @author Studenikin Sergey <studenikin.s@gmail.com>
 */
interface CategoryManagerInterface extends GeneralManagerInterface
{

    /**
     * Return an object by the slug
     *
     * @param string $slug
     * @return \CF\TheForumBundle\Model\CategoryInterface
     */
    public function findBySlug($slug);

    /**
     * Return moderator role name for the category
     *
     * @param string $slug
     * @return string
     */
    public function getModeratorRoleNameByCategory(CategoryInterface $category);
}