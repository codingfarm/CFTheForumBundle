<?php
namespace CF\TheForumBundle\Editor\Filters;

use mjohnson\decoda\filters\FilterAbstract;
use CF\TheForumBundle\Editor\Decoda;
use Symfony\Bundle\FrameworkBundle\Routing\Router; //use mjohnson\decoda\filters\ImageFilter as BaseImageFilter;

class ForumVideoFilter extends FilterAbstract
{
//    const IMAGE_PATTERN = '#^/uploads/.+\.(?:jpg|jpeg|png|gif|bmp)$#is';
    private $iframeWidth;
    private $iframeHeight;
    /** @var Router */
    private $router;

    public function __construct(array $config = array(), Router $router)
    {
        $this->iframeWidth  = $config['iframe_width'];
        $this->iframeHeight = $config['iframe_height'];
        unset($config['iframe_height'], $config['iframe_width']);
        $this->router = $router;
        parent::__construct($config);
    }



    protected $_tags = array(
        'forumvideo'   => array(
            'htmlTag'        => 'iframe',
            'displayType'    => Decoda::TYPE_INLINE,
            'allowedTypes'   => Decoda::TYPE_NONE,
            'autoClose'      => false
        )
    );

    /**
     * Use the content as the image source.
     *
     * @access public
     * @param array $tag
     * @param string $content
     * @return string
     */
    public function parse(array $tag, $content)
    {

        // If more than 1 http:// is found in the string, possible XSS attack
        if ((substr_count($content, 'http://') + substr_count($content, 'https://')) > 1) {
            return null;
        }

        $url = $this->router->generate('forum_get_video',array('videourl'=>$content));
        $tag['attributes']['src']    = $url;
        $tag['attributes']['width']  = $this->iframeWidth;
        $tag['attributes']['height'] = $this->iframeHeight;
        $tag['attributes']['frameborder']=0;


        return parent::parse($tag, $content);
    }

    public function setRouter(Router $router)
    {
        $this->router = $router;
    }
}