<?php
/*
 * This file is part of the CF TheForumBundle
 */

namespace CF\TheForumBundle\VideoUrlParser;

use CF\TheForumBundle\VideoUrlParser\AbstractVideoUrlParser;
/**
 * Class for the rendering embed html code from video url of the portal youtube.com
 *
 * @author Studenikin Sergey <studenikin.s@gmail.com>
 */
class YoutubeVideoUrlParser extends AbstractVideoUrlParser
{

    public  function getEmbedUrl()
    {
        $return = false;

        preg_match_all('/(youtu.be\/|\/watch\?v=|\/embed\/)([a-z0-9\-_]+)/i',$this->url,$matches);
        if(isset($matches[2])){

            foreach($matches[2] as $key=>$id) {
                $return = "http://www.youtube.com/embed/$id";
            }
        }

        return $return;
    }

    public function getServiceUrl()
    {
        return "youtube.com";
    }

}

