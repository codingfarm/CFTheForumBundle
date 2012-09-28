<?php
/*
 * This file is part of the CF TheForumBundle
 */

namespace CF\TheForumBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use CF\TheForumBundle\Model\Topic as BaseTopic;
use DateTime;

/**
 * @ORM\MappedSuperclass
 */
abstract class Topic extends  BaseTopic
{

    /**
    * @ORM\Id
    * @ORM\Column(type="integer")
    * @ORM\GeneratedValue(strategy="AUTO")
    */
    private $id;

    /**
     * @ORM\Column(type="datetime", name="created_date")
     */
    private $createdDate;


    /**
     * @ORM\Column(type="datetime", name="updated_date", nullable="true")
     */
    private $updatedDate;

    /**
     * @ORM\Column(type="integer", name="count_posts", nullable="true")
     */
    private $countPosts;

    /**
     * @ORM\Column(type="string", length=100)
     */
    private $name;


    public function __construct()
    {
        $this->posts = new \Doctrine\Common\Collections\ArrayCollection();
        $this->createdDate = new DateTime();
        $this->updatedDate = $this->createdDate;
        $this->countPosts = 1;
    }
    
    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set createdDate
     *
     * @param datetime $createdDate
     */
    public function setCreatedDate($createdDate)
    {
        $this->createdDate = $createdDate;
    }

    /**
     * Get createdDate
     *
     * @return datetime 
     */
    public function getCreatedDate()
    {
        return $this->createdDate;
    }

    /**
     * Set updatedDate
     *
     * @param datetime $updatedDate
     */
    public function setUpdatedDate($updatedDate)
    {
        $this->updatedDate = $updatedDate;
    }

    /**
     * Get updatedDate
     *
     * @return datetime 
     */
    public function getUpdatedDate()
    {
        return $this->updatedDate;
    }



    /**
     * Add posts
     *
     * @param \CF\TheForumBundle\Model\PostInterface $posts
     */

    public function addPost(\CF\TheForumBundle\Model\PostInterface $posts)
    {
        $this->posts[] = $posts;
    }

    /**
     * Get posts
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getPosts()
    {
        return $this->posts;
    }

    /**
     * Set name
     *
     * @param string $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * Get name
     *
     * @return string 
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set countPosts
     *
     * @param integer $countPosts
     */
    public function setCountPosts($countPosts)
    {
        $this->countPosts = $countPosts;
    }

    /**
     * Get countPosts
     *
     * @return integer 
     */
    public function getCountPosts()
    {
        return $this->countPosts;
    }



}