<?php

/*
 * This file is part of the CF TheForumBundle
 */
namespace CF\TheForumBundle\Bridge;

/**
 * UserMetaInterface.
 *
 * @author Studenikin Sergey <studenikin.s@gmail.com>
 */
interface UserMetaInterface
{

    /**
     * Indicates whether to show user's avatars or not
     *
     * @return boolean
     */
    public function isAvatarsEnabled();

    /**
     * Return the name of the user
     *
     * @param $user
     * @return string
     */
    public function getUsername($user);

    /**
     * Return the picture's url of user's avatar
     *
     * @param $user
     * @return string (/img/avatars/default.gif)
     */
    public function getUserAvatar($user);
}
