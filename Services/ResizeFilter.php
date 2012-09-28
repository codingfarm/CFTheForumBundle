<?php
/*
 * This file is part of the CF TheForumBundle
 */


namespace CF\TheForumBundle\Services;

use CF\TheForumBundle\Services\ResizeFilterInterface;
use Imagine\Image\Box as Box;
use Imagine\Gd\Imagine as Imagine;
use Imagine\Filter\Basic\Thumbnail;
use Imagine\Image\ImageInterface as ImageInterface;


/**
 * ResizeFilter.
 *
 * Realization for resizing an image and saving the resizing image in the server
 * Example of using:
 *
 * $resizer
 *      ->setFile($_FILES['img']['tmp_name'])
 *      ->setPath('/uploads/forum/')
 *      ->setFileName('newfile.jpg')
 *      ->setMaxHeight(500)
 *      ->setMaxWidth(300)
 *      ->save();
 *
 * @author Studenikin Sergey <studenikin.s@gmail.com>
 */
class ResizeFilter  implements ResizeFilterInterface
{

    private $kernel;

    /**
     * @var string Path to the file in our server
     */
    private $file = "";

    /**
     * @var string - folder where we want to save file
     */
    private $path = "";

    /**
     * @var string - The name of new file
     */
    private $fileName = "";

    private $maxHeight = 200;

    private $maxWidth = 200;


    public function __construct($kernel)
    {
         $this->kernel = $kernel;
    }

    public function setFile($file)
    {
        $this->file = $file;

        return $this;
    }

    public function setPath($path)
    {
        $this->path = trim($path, '/');

        return $this;
    }

    public function setFileName($fileName)
    {
        $this->fileName = $fileName;

        return $this;
    }

    public function setMaxHeight($maxHeight)
    {
        $this->maxHeight = $maxHeight;

        return $this;
    }

    public function setMaxWidth($maxWidth)
    {
        $this->maxWidth = $maxWidth;

        return $this;
    }

    public function save()
    {
        $dir = trim($this->kernel->getRootDir() . '/../web/' . $this->path . DIRECTORY_SEPARATOR);
        $dir = str_replace("/", DIRECTORY_SEPARATOR, $dir);
        $this->ifDirNotExistCreate($dir);

        list($width, $height) = getimagesize($this->file);
        $this->maxHeight = ($this->maxHeight <= $height) ? $this->maxHeight : $height;
        $this->maxWidth = ($this->maxWidth <= $width) ? $this->maxWidth : $width;
        $ratioHeight = $this->maxHeight / $height;
        $ratioWidth = $this->maxWidth / $width;
        $ratio = min($ratioHeight, $ratioWidth);
        $width = intval($ratio * $width);
        $height = intval($ratio * $height);

        $imagine = new Imagine();
        $size    = new Box($width, $height);
        $mode    = ImageInterface::THUMBNAIL_INSET;

        $imagine->open($this->file)
            ->thumbnail($size, $mode)
            ->save($dir . $this->fileName);

    }

    /**
     * If there was not found the directory, then to create it.
     *
     * @param string $dir
     * @return bool
     */
    private function ifDirNotExistCreate($dir)
    {
        if (file_exists($dir)) {

            return true;
        } else {

            return mkdir($dir, 0775, true);
        }

    }
}
