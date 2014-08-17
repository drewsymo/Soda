<?php

namespace Soda\Component\Theme\Extension;

use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Extension\Extension;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;

/**
 * Theme Config Extension Class.
 *
 * The Theme Config Extension Class sets up our theme definition file
 * for inclusion into the container.
 * 
 * @package    Soda Standard Edition
 * @author     Drew Morris <drewsy.morris@gmail.com>
 * @copyright  2014 Drew Morris
 * @license    MIT
 * @since      1.0
 */
class ThemeConfigExtension extends Extension
{
    /**
     * Load the theme definition.
     * @param  array            $configs   Existing configuration array.
     * @param  ContainerBuilder $container Instance of container.
     */
    public function load(array $configs, ContainerBuilder $container)
    {
		$loader = new YamlFileLoader($container, new FileLocator(get_template_directory() . '/config'));
		$loader->load('theme.yml');

        $this->container = $container;
        $this->setPaths();
    }

    private function setPaths()
    {
        if(is_child_theme())
        {
            $this->container->setParameter('theme.path', get_stylesheet_directory());
            $this->container->setParameter('theme.uri', get_stylesheet_directory_uri());
        }
        else
        {
            $this->container->setParameter('theme.path', get_template_directory());
            $this->container->setParameter('theme.uri', get_template_directory_uri());
        }
    }

    /**
     * Set up the theme definition namespace.
     * @return string The alias.
     */
    public function getAlias()
    {
        return 'theme';
    }	
}