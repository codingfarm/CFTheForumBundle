<?php
/*
 * This file is part of the CF TheForumBundle
 */


namespace CF\TheForumBundle\Services;

use CF\TheForumBundle\Services\PermissionsInterface;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * ResizeFilterInterface.
 *
 * Interface for resizing an image and saving the resizing image in the server
 * @author Studenikin Sergey <studenikin.s@gmail.com>
 */
interface ResizeFilterInterface
{

    /**
     * Path to the file in our server
     * @param string $file
     */
    public function setFile($file);

    /**
     * Path to a new location of the file (folder where we want to save file)
     * @param string $path relative to the main server directory
     */
    public function setPath($path);

    /**
     * Sets the name of the new file
     * @param string $fileName
     */
    public function setFileName($fileName);

    /**
     * Sets maximum height (px) of new file.
     * @param integer $maxHeight
     */
    public function setMaxHeight($maxHeight);

    /**
     * Sets maximum width (px) of new file.
     * @param integer $maxWidth
     */
    public function setMaxWidth($maxWidth);

    /**
     * Resize and save the file in the new folder
     */
    public function save();

}
