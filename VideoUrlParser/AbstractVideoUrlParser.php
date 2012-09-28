<?php
/*
 * This file is part of the CF TheForumBundle
 */

namespace CF\TheForumBundle\VideoUrlParser;

use CF\TheForumBundle\VideoUrlParser\VideoUrlParserInterface as VideoUrlParserInterface;

/**
 * Abstract class for the rendering embed html code from url of the video-portal.
 *
 * @author Studenikin Sergey <studenikin.s@gmail.com>
 */
abstract class AbstractVideoUrlParser implements VideoUrlParserInterface
{

    abstract public function getEmbedUrl();

    abstract public function getServiceUrl();

    /**
     * @var url of the video. For example: http://www.youtube.com/watch?v=ZV2VVk8dvxE&feature=g-logo-xit
     */
    protected $url;

    /**
     * @var int - the height of the generated video
     */
    protected $heigh = 225;

    /**
     * @var int - the width of the generated video
     */
    protected $width = 400;

    public function setUrl($url)
    {
        $this->url = $url;
    }

    public function getUrl()
    {
        return $this->url;
    }

    public function getHeight()
    {
        return $this->heigh;
    }

    public function setHeight($height)
    {
        $this->heigh = $height;
    }

    public function getWidth()
    {
        return $this->width;
    }

    public function setWidth($width)
    {
        $this->width = $width;
    }

    public function  getHtml()
    {
        if ($this->getEmbedUrl()) {
            //return '<iframe width="' . $this->getWidth() . '" height="' . $this->getHeight() . '" src="' . $this->getEmbedUrl() . '" frameborder="0" allowfullscreen></iframe>';
            return '<iframe width="100%" height="' . $this->getHeight() . '" src="' . $this->getEmbedUrl() . '" frameborder="0" allowfullscreen></iframe>';
        } else {
            return false;
        }
    }

    public function isUrlInServiceList()
    {
        if (preg_match('#^http://(www\.)?' . $this->getServiceUrl() . '#', $this->url)) {
            return true;
        } else {
            return false;
        }
    }
}
