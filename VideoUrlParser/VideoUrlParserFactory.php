<?php
/*
 * This file is part of the CF TheForumBundle
 */

namespace CF\TheForumBundle\VideoUrlParser;

use CF\TheForumBundle\VideoUrlParser\VideoUrlParserInterface as VideoUrlParserInterface;
use Exception;

/**
 * Class returns html embed video code from an url of a video.
 * How to use it:
 *  1. define list of services in the file service.yml
 *  2. After use code such this:
 *  $videoUrlParser = new VideoUrlParser();
 *  $videoUrlParser->setServiceList(array('forum.services.video.youtube', 'forum.services.video.rutube', 'forum.services.video.smotri'));
 *  $parser = $videoUrlParser->getParser("http://smotri.com/video/view/?id=v22430315db2");
 *  if ($parser) {
 *      $parser->setHeight($this->container->parameters['forum.video.height']);
 *      $parser->setWidth($this->container->parameters['forum.video.width']);
 *      $embed = $parser->getHtml();
 *  } else {
 *      $embed = "There is url of the video-portal which is not in our list";
 * }
 *
 *
 * @author Studenikin Sergey <studenikin.s@gmail.com>
 */
class VideoUrlParserFactory
{
    /**
     * @var array of classes(every class has to be define like a service)
     */
    private $serviceList = array();

    /**
     * @var - @service_container
     */
    private $container;

    public function __construct($container)
    {
        $this->container = $container;
    }

    /**
     * @param array $services - list of concrete video url services.
     */
    public function setServiceList($services)
    {
        $this->serviceList = $services;
    }

    /**
     * @return array - return the list of servisces
     */
    public function getServiceList()
    {
        return $this->serviceList;
    }

    /**
     * @param string $url of video. For example: http://www.youtube.com/watch?v=KptFAvfcNsI&feature=g-logo-xit
     * @return bool|\Exception|concrete class
     */
    public function getParser($url)
    {

        foreach($this->getServiceList() as $serviceName) {

            $parserService = $this->container->get($serviceName);

            if ($parserService instanceof VideoUrlParserInterface) {

                $parserService->setUrl($url);
                if ($parserService->isUrlInServiceList()) {

                    return $parserService;
                }
            } else {

               return new Exception($serviceName . " is not instanceof CF\TheForumBundle\VideoUrlParser\VideoUrlParserInterface");

            }
        }

         return false;
    }
}
