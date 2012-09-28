<?php
/*
 * This file is part of the CF TheForumBundle
 */

namespace CF\TheForumBundle\VideoUrlParser;

use CF\TheForumBundle\VideoUrlParser\AbstractVideoUrlParser;
/**
 * Class for the rendering embed html code from video url of the portal vimeo.com
 *
 * @author Studenikin Sergey <studenikin.s@gmail.com>
 */
class VimeoVideoUrlParser extends AbstractVideoUrlParser
{

    public  function getEmbedUrl()
    {
        $return = false;

        preg_match('#vimeo.com/(\d+)#', $this->url, $matches);
        if(isset($matches[1])){
            $return = "http://player.vimeo.com/video/$matches[1]";
        }

        return $return;
    }

    public function getServiceUrl()
    {
        return "vimeo.com";
    }
}
