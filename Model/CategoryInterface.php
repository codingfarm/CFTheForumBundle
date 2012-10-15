<?php
/*
 * This file is part of the CF TheForumBundle
 */

namespace CF\TheForumBundle\Model;

/**
 * CategoryInterface.
 *
 * Any post to be used by CF\TheForumBundle must implement this interface.
 *
 * @author Studenikin Sergey <studenikin.s@gmail.com>
 */
interface CategoryInterface
{
    /**
     * Return id
     */
    public function getId();

    /**
     * Set the title of the category
     *
     * @param string $name
     */
    public function setName($name);

    /**
     * Return the title of the category
     *
     * @return string
     */
    public function getName();

    /**
     * Return the slug of the category
     *
     * @return string
     */
    public function getSlug();

    /**
     * Set the slug of the category
     *
     * @param string $slug
     */
    public function setSlug($slug);

    /**
     * Set order of the category
     *
     * @param integer $priority
     */
    public function setPriority($priority);

    /**
     * Return the order of the category
     *
     * @return integer
     */
    public function getPriority();
}