<?php
/*
 * This file is part of the CF TheForumBundle
 */

namespace CF\TheForumBundle\Entity;

use DateTime;

/**
 * Default ORM implementation of PostInterface.
 *
 * Must be extended and properly mapped by the end developer.
 *
 * @author Studenikin Sergey <studenikin.s@gmail.com>
 */
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use CF\TheForumBundle\Model\Post as AbstractPost;
use FOS\UserBundle\Entity\User;
use CF\TheForumBundle\Model\PostInterface as PostInterface;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\MappedSuperclass
 */
abstract class Post extends AbstractPost
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
     * @ORM\Column(type="datetime", name="user_updated_date", nullable="true")
     */
    private $authorUpdatedDate;


    /**
     * @ORM\Column(type="datetime", name="moderator_updated_date", nullable="true")
     */
    private $moderatorUpdatedDate;

    /**
     * @Assert\NotBlank()
     * @ORM\Column(type="text")
     */
    private $body;


    /**
     * @ORM\Column(type="integer", name="author_ip", nullable="true")
     */
    private $authorIp;

    /**
     * @ORM\Column(type="boolean", nullable=false)
     */
    private $isBlocked = false;
    /**
     * @ORM\Column(type="boolean", nullable=false)
     */
    private $isDeleted = false;


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
    public function setCreatedDate(DateTime $createdDate)
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
     * Set moderatorUpdatedDate
     *
     * @param datetime $moderatorUpdatedDate
     */
    public function setModeratorUpdatedDate($moderatorUpdatedDate)
    {
        $this->moderatorUpdatedDate = $moderatorUpdatedDate;
    }

    /**
     * Get moderatorUpdatedDate
     *
     * @return datetime
     */
    public function getModeratorUpdatedDate()
    {
        return $this->moderatorUpdatedDate;
    }

    /**
     * Set body
     *
     * @param text $body
     */
    public function setBody($body)
    {
        $this->body = $body;
    }

    /**
     * Get body
     *
     * @return text
     */
    public function getBody()
    {
        return $this->body;
    }


    /**
     * Set authorUpdatedDate
     *
     * @param datetime $authorUpdatedDate
     */
    public function setAuthorUpdatedDate($authorUpdatedDate)
    {
        $this->authorUpdatedDate = $authorUpdatedDate;
    }

    /**
     * Get authorUpdatedDate
     *
     * @return datetime
     */
    public function getAuthorUpdatedDate()
    {
        return $this->authorUpdatedDate;
    }

    public function getIsBlocked()
    {
        return $this->isBlocked;
    }

    public function setIsBlocked($isBlocked)
    {
        $this->isBlocked = $isBlocked;
    }

    public function getIsDeleted()
    {
        return $this->isDeleted;
    }

    public function setIsDeleted($isDeleted)
    {
        $this->isDeleted = $isDeleted;
    }


    public function setAuthorIp($ipAsString)
    {
        $this->authorIp = ip2long($ipAsString);
    }

    public function getAuthorIp($asInt = false)
    {
        if ($asInt) {
            return $this->authorIp;
        }

        return long2ip($this->authorIp);
    }
}