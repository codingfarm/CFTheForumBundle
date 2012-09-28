<?php
/*
 * This file is part of the CF TheForumBundle
 */

namespace CF\TheForumBundle\VideoUrlParser;

use CF\TheForumBundle\VideoUrlParser\AbstractVideoUrlParser;
/**
 * Class for the rendering embed html code from video url of the portal smotri.com
 *
 * @author Studenikin Sergey <studenikin.s@gmail.com>
 */
class SmotriVideoUrlParser extends AbstractVideoUrlParser
{

    public  function getEmbedUrl()
    {
        preg_match('#smotri.com/video/view/\?id=([a-z0-9]+)#', $this->url, $matches);
        if(isset($matches[1])){

            return $matches[1];
        }

        return  false;
    }

    public function  getHtml()
    {

        if ($this->getEmbedUrl()) {

            return '<object id="smotriComVideoPlayer' . $this->getEmbedUrl() . '_1347458830.1382_1172" classid="clsid:d27cdb6e-ae6d-11cf-96b8-444553540000" width="640" height="360"><param name="movie" value="http://pics.smotri.com/player.swf?file=' . $this->getEmbedUrl() . '&bufferTime=3&autoStart=false&str_lang=rus&xmlsource=http%3A%2F%2Fpics.smotri.com%2Fcskins%2Fblue%2Fskin_color.xml&xmldatasource=http%3A%2F%2Fpics.smotri.com%2Fskin_ng.xml" /><param name="allowScriptAccess" value="always" /><param name="allowFullScreen" value="true" /><param name="bgcolor" value="#ffffff" /><embed src="http://pics.smotri.com/player.swf?file=' . $this->getEmbedUrl() . '&bufferTime=3&autoStart=false&str_lang=rus&xmlsource=http%3A%2F%2Fpics.smotri.com%2Fcskins%2Fblue%2Fskin_color.xml&xmldatasource=http%3A%2F%2Fpics.smotri.com%2Fskin_ng.xml" quality="high" allowscriptaccess="always" allowfullscreen="true" wmode="opaque"  width="' . $this->getWidth() . '" height="' . $this->getHeight() . '" type="application/x-shockwave-flash"></embed></object>';
        } else {

            return false;
        }
    }

    public function getServiceUrl()
    {
        return "smotri.com";
    }
}

