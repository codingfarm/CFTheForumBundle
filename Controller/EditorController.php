<?php

namespace CF\TheForumBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Exception;
use TTK\FrameworkBundle\Response\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use CF\TheForumBundle\Editor\MyDecoda;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use CF\TheForumBundle\Editor\Filters\BBcodeFilter;
use CF\TheForumBundle\VideoUrlParser\VideoUrlParserFactory;

/**
 * The class for work with WYSIWYG-editor
 */
class EditorController extends BaseController
{

    /**
     * Downloads an image from the editor to server
     *
     * @param \Symfony\Component\HttpFoundation\Request $request
     * @return array|\Symfony\Component\HttpFoundation\Response|\TTK\FrameworkBundle\Response\JsonResponse
     */
    public function imageUploadAction(Request $request)
    {

        $imageName = uniqid(rand(0, 99999999)).time() . ".jpg";
        $dir = $this->container->parameters['forum.image.upload_dir'];
        if ($dir != "/") {
            $dir = trim($dir, '/');
            $dir = "/" . $dir . "/";
        }

        $resizer = $this->container->get('forum.services.resizer');
        try {
            $resizer
                ->setFile($_FILES['img']['tmp_name'])
                ->setPath($dir)
                ->setFileName($imageName)
                ->setMaxHeight($this->container->parameters['forum.image.max_height'])
                ->setMaxWidth($this->container->parameters['forum.image.max_width'])
                ->save();

                $imganswer = $dir . $imageName;
                $status = 1;
                $msg = 'OK';

        } catch (Exception $e) {
            $status = 0;
            $imganswer = false;
            $msg = $this->get('translator')->trans('Hello '.$name);
        }

        #use for iframe upload
        if ($request->get('iframe')) {

            $response = new \Symfony\Component\HttpFoundation\Response(
                '<html><body>OK<script>window.parent.$("#' . $request->get('idarea') .
                      '").insertImage("' . $imganswer . '","' ."" .
                      '").closeModal().updateUI();</script></body></html>');
        } else {
            $response = array(
                'status' => $status,
                'msg' => $msg,
            );
            if ($status) {
                $response['image_link'] = $imganswer;
                $response['thumb_link'] ="";
            }

            $response = new JsonResponse($response);
        }

        return $response;
    }

    /**
     * Renders html-code of video by video's url
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function getVideoAction()
    {
        $videoUrl = $this->getRequest()->get('videourl');
        $videoUrlParser = $this->get('forum.services.video_url_parser');
        $videoUrlParser->setServiceList($this->container->parameters['forum.video_url_services']);
        $parser = $videoUrlParser->getParser($videoUrl); //http://smotri.com/video/view/?id=v22430315db2#

        if ($parser) {
            $parser->setHeight($this->container->parameters['forum.video.height']);
            $parser->setWidth($this->container->parameters['forum.video.width']);

            $embed = $parser->getHtml();
            if (!$embed) {

                //There is error in the url of video service
                return new Response('Ошибка в адресе. Проверьте адрес.');
            }

            return new Response("<html><body style='padding: 0px; margin: 0px;'>" . $embed . "</body></html>");
        } else {

            //There is url to the video-portal which is not in our list
            return new Response('Видео с неизвестного источника');
        }
    }
}
