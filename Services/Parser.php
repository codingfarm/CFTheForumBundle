<?php

namespace CF\TheForumBundle\Services;

use CF\TheForumBundle\Editor\Decoda;
use Symfony\Component\DependencyInjection\ContainerAware;
use CF\TheForumBundle\Editor\Filters\ForumVideoFilter;
use CF\TheForumBundle\Editor\Filters\ImageFilter;
use CF\TheForumBundle\Editor\Filters\BBcodeFilter;

class Parser extends ContainerAware
{
    private $decoda;

    function __construct($filters, $container)
    {
        $this->setContainer($container);

        $this->decoda = new Decoda();
        $this->decoda
//            ->setLocale('ru-ru')
            ->setShorthand(false)
            ->setXhtml()
            ->setStrict();

        foreach ($filters as $filterServiceId) {
            /** @var $filter  \mjohnson\decoda\filters\Filter */
            $filter = $this->container->get($filterServiceId);
            $this->decoda->addFilter($filter);
        }
    }

    public function bbcode($text)
    {
        $text = trim($text);
        $text = preg_replace("/(\s){5,}/s", "\n\n\n", $text);
        $text = $this->decoda->reset($text, false)->parse();
        return $text;
    }

    public function escapeHTML($value = true)
    {
        $this->decoda->setEscaping($value);

        return $this;
    }
}