<?php

namespace CF\TheForumBundle\DependencyInjection;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\DependencyInjection\Loader;

/**
 * This is the class that loads and manages your bundle configuration
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/extension.html}
 */
class CFTheForumExtension extends Extension
{
    /**
     * {@inheritDoc}
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $configuration = new Configuration();
        $config        = $this->processConfiguration($configuration, $configs);

        $loader = new Loader\YamlFileLoader($container, new FileLocator(__DIR__ . '/../Resources/config'));

        $dbDriver = $config['db_driver'];

        $loader->load(sprintf('%s.yml', $dbDriver));
        $loader->load('form.yml');
        $loader->load('bridge.yml');
        $loader->load('bbcodes.yml');
        $loader->load('services.yml');
        $loader->load('twig.yml');


        if (!empty($config['class']['model']['post'])) {
            $container->setParameter('forum.post.class', $config['class']['model']['post']);
        }
        if (!empty($config['class']['model']['topic'])) {
            $container->setParameter('forum.topic.class', $config['class']['model']['topic']);
        }
        if (!empty($config['class']['model']['category'])) {
            $container->setParameter('forum.category.class', $config['class']['model']['category']);
        }
        if (!empty($config['class']['bridge']['user_meta'])) {
            $container->setParameter('forum.bridge.user_meta.class', $config['class']['bridge']['user_meta']);
        }
         if (!empty($config['video_url_services'])) {
            $container->setParameter('forum.video_url_services', $config['video_url_services']);
        }
        if (!empty($config['image']['upload_dir'])) {
            $container->setParameter('forum.image.upload_dir', $config['image']['upload_dir']);
        }
        if (!empty($config['image']['max_height'])) {
            $container->setParameter('forum.image.max_height', $config['image']['max_height']);
        }
        if (!empty($config['image']['max_width'])) {
            $container->setParameter('forum.image.max_width', $config['image']['max_width']);
        }
        if (!empty($config['video']['width'])) {
            $container->setParameter('forum.video.width', $config['video']['width']);
        }
        if (!empty($config['video']['height'])) {
            $container->setParameter('forum.video.height', $config['video']['height']);
        }

        if (!isset($config['templates'])) {
            $config['templates'] = array();
        }
        if (!isset($config['templates']['layout'])) {
            $config['templates']['layout'] = 'CFTheForumBundle::forum_layout.html.twig';
        }

        if (!empty($config['bbcode_filters'])){
            $container->setParameter('forum.bbcode_filters',$config['bbcode_filters']);
        }

        $container->setParameter('forum.templates.layout', $config['templates']['layout']);
    }
}
