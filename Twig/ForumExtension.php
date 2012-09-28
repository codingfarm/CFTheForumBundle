<?php

namespace CF\TheForumBundle\Twig;

use Twig_Extension;
use Twig_Extensions_Extension_Text;
use Twig_Filter_Method;
use Twig_Filter_Function;
use CF\TheForumBundle\Services\Parser;
use CF\TheForumBundle\Bridge\UserMetaInterface;
use CF\TheForumBundle\Services\PermissionsInterface;

class ForumExtension extends Twig_Extensions_Extension_Text
{
    private $userMeta;
    private $permissions;
    private $parser;
    private $layoutTemplate;
    private $container;

    /**
     * @param \CF\TheForumBundle\Bridge\UserMetaInterface $userMeta
     * @param \CF\TheForumBundle\Services\PermissionsInterface $permissions
     * @param \CF\TheForumBundle\Services\Parser $parser
     * @param string $layoutTemplate
     */
    public function __construct(UserMetaInterface $userMeta, PermissionsInterface $permissions, Parser $parser, $container, $layoutTemplate)
    {
        $this->userMeta       = $userMeta;
        $this->permissions    = $permissions;
        $this->parser         = $parser;
        $this->layoutTemplate = $layoutTemplate;
        $this->container      = $container;
    }

    public function getName()
    {
        return 'cf_forum_extension';
    }

    public function getGlobals()
    {
        return array(
            'user_meta'   => $this->userMeta,
            'permissions' => $this->permissions,
            'parser'      => $this->parser,
            'forum_layout_template'=> $this->layoutTemplate,
            'video_parameters' => array("width" => $this->container->parameters['forum.video.width'], "height" => $this->container->parameters['forum.video.height'])
        );
    }


}