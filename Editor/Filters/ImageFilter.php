<?php
namespace CF\TheForumBundle\Editor\Filters;

use mjohnson\decoda\filters\FilterAbstract;
use CF\TheForumBundle\Editor\Decoda; //use mjohnson\decoda\filters\ImageFilter as BaseImageFilter;
//use mjohnson\decoda\filters\ImageFilter as decImageFilter;

class ImageFilter extends FilterAbstract
{
    const IMAGE_PATTERN = '#^/uploads/.+\.(?:jpg|jpeg|png|gif|bmp)$#is';

    protected $_tags = array(
        'img'   => array(
            'htmlTag'        => 'img',
            'displayType'    => Decoda::TYPE_INLINE,
            'allowedTypes'   => Decoda::TYPE_NONE,
            'contentPattern' => self::IMAGE_PATTERN,
            'autoClose'      => true
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
    public function parse(array $tag, $content) {

        // If more than 1 http:// is found in the string, possible XSS attack
        if ((substr_count($content, 'http://') + substr_count($content, 'https://')) > 1) {
            return null;
        }

        $tag['attributes']['src'] = $content;

        return parent::parse($tag, $content);
    }

}
