<?php
/*
 * This file is part of the CF TheForumBundle
 */

namespace CF\TheForumBundle\VideoUrlParser;
/**
 * Interface for the rendering video html code from an url of the video portal.
 *
 * @author Studenikin Sergey <studenikin.s@gmail.com>
 */
interface VideoUrlParserInterface {

    /**
     * @param string $url of a video
     * For example: http://smotri.com/video/view/?id=v22430315db2#
     */
    public function setUrl($url);

    /**
     * Return url
     * @return string
     */
    public function getUrl();

    /**
     * Return the url which we include in the iframe
     * @return string
     */
    public function getEmbedUrl();

    /**
     * Return a ready video code in the iframe or the object tag.
     * @return string
     */
    public function getHtml();

    /**
     * Returns the height of the video
     * @return integer
     */
    public function getHeight();

    /**
     * Set the height of the video
     * @param $height integer
     */
    public function setHeight($height);

    /**
     * Set the width of the video
     * @param $width integer
     */
    public function setWidth($width);

    /**
     * Returns the width of the video
     * @return integer
     */
    public function getWidth();

    /**
     * Check whether the server of video's url is in the list of allow services
     *
     * @return boolean
     */
    public function isUrlInServiceList();

    /**
     * Returns the url of concrete service. For example: youtube.com
     * Is determined in particular class
     * @return string
     */
    public function getServiceUrl();

}

