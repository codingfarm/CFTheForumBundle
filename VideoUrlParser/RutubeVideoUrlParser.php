<?php
/*
 * This file is part of the CF TheForumBundle
 */

namespace CF\TheForumBundle\VideoUrlParser;

use CF\TheForumBundle\VideoUrlParser\AbstractVideoUrlParser;
/**
 * Class for the rendering embed html code from video url of the portal rutube.ru.
 *
 * @author Studenikin Sergey <studenikin.s@gmail.com>
 */
class RutubeVideoUrlParser extends AbstractVideoUrlParser
{

    public  function getEmbedUrl()
    {
        $return = false;

        preg_match('#rutube.ru/video/([a-z0-9]+)/#', $this->url, $matches);

        if(isset($matches[1])){

            $answer = file_get_contents("http://rutube.ru/api/video/" . $matches[1] . "?format=json");
            $params = json_decode($answer);

             /*
              * $params->html returns a ready html iframe-code.
              * Parse from it url of video
              */
            preg_match('#src="(.+?)"#', $params->html, $matches);
            if(isset($matches[1])){

                return $matches[1];
            }
        }

        return $return;
    }

    public function getServiceUrl()
    {
        return "rutube.ru";
    }

}
