<?php
/*
 * This file is part of the CF TheForumBundle
 */
namespace CF\TheForumBundle\Bridge;

/**
 * Class for general work with users: whether show avatar, get user's name etc
 */
abstract class UserMeta implements UserMetaInterface
{
    /**
     * @var bool - the indicator. Determines whether to show user's avatars or not
     */
    private $isAvatarsEnabled = false;

    public function __construct($isAvatarEnabled)
    {
        $this->isAvatarsEnabled = (boolean)$isAvatarEnabled;
    }

    public function isAvatarsEnabled()
    {
        return $this->isAvatarsEnabled;
    }

}