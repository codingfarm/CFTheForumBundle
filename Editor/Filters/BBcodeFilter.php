<?php

namespace CF\TheForumBundle\Editor\Filters;

use mjohnson\decoda\filters\FilterAbstract;
use CF\TheForumBundle\Editor\Decoda;

class BBcodeFilter extends FilterAbstract
{

    /**
     * Supported tags.
     *
     * @access protected
     * @var array
     */
    protected $_tags = array(
        'b'    => array(
            'htmlTag'      => array('b', 'strong'),
            'displayType'  => Decoda::TYPE_INLINE,
            'allowedTypes' => Decoda::TYPE_INLINE
        ),
        'i'    => array(
            'htmlTag'      => array('i', 'em'),
            'displayType'  => Decoda::TYPE_INLINE,
            'allowedTypes' => Decoda::TYPE_INLINE
        ),
        '*'    => array(
            'htmlTag'      => 'li',
            'displayType'  => Decoda::TYPE_BLOCK,
            'allowedTypes' => Decoda::TYPE_BOTH,
            'parent'       => array('list')
        ),
        'list' => array(
            'htmlTag'           => 'ul',
            'displayType'       => Decoda::TYPE_BLOCK,
            'allowedTypes'      => Decoda::TYPE_BOTH,
            'lineBreaks'        => Decoda::NL_REMOVE,
            'childrenWhitelist' => array('*'),
        )
    );
}