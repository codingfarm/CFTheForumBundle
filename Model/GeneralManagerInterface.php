<?php
/*
 * This file is part of the CF TheForumBundle
 */

namespace CF\TheForumBundle\Model;

/**
 * GeneralManagerInterface.
 *
 * Interface for general working with a database.
 *
 * @author Studenikin Sergey <studenikin.s@gmail.com>
 */
interface GeneralManagerInterface
{
    /**
     * Return an object by the id
     *
     * @param $id
     */
    public function findById($id);

    /**
     * Persist the object
     *
     * @param $object
     * @param bool $andFlush
     */
    public function persist($object, $andFlush=true);

    /**
     * Returns  
     *
     * @return objects
     */
    public function getList();
}