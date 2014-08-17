<?php

namespace Soda\Component\Theme;

use Soda\Component\Theme\Extension\ThemeConfigExtension;
use Soda\Component\SupportManager\SupportManager;
use Soda\Component\Cache\Cache;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Dumper\PhpDumper;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;
use Symfony\Component\Config\FileLocator;

/**
 * Theme Class.
 *
 * This class is the kernel of our theme, it builds our container and sets up our
 * theme components, such as assets, sidebars, menus and feature support.
 *
 * @todo  Need to create cache directory if it doesn't exist. http://symfony.com/doc/current/components/filesystem.html
 */
class Theme
{
	/**
	 * Instance of the container.
	 * @var ContainerBuilder
	 */
	protected $container;

	/**
	 * Setup the hooks for our theme.
	 */
	public function __construct()
	{
		$this->setCache();
		$this->setContainer();

		add_action('wp_enqueue_scripts', [$this, 'setAssets']);
		add_action('after_setup_theme',  [$this, 'setMenus']);
		add_action('after_setup_theme',  [$this, 'setSidebars']);
		add_action('after_setup_theme',  [$this, 'setSupport']);
		add_action('after_setup_theme',  [$this, 'boot']);
	}

	/** 
	 * Determines if WordPress is in debug mode.
	 * @return boolean
	 */
	public function isDebug()
	{
		if(WP_DEBUG)
			return true;

		return false;
	}

	/**
	 * Service getter for our theme.
	 * @param  string $service Service to retrieve from container.
	 * @return object The service.
	 */
	public function get($service)
	{
		return $this->container->get($service);
	}

	/**
	 * Setup theme assets.
	 */
	public function setAssets()
	{
		$this->assets = $this->container->get('assets');

		if($this->container->hasParameter('theme.styles'))
		{
			$styles = $this->container->getParameter('theme.styles');
			$this->assets->addStyles($styles);
		}

		if($this->container->hasParameter('theme.scripts'))
		{
			$scripts = $this->container->getParameter('theme.scripts');
			$this->assets->addScripts($scripts);
		}
	}

	/**
	 * Setup theme menus.
	 */
	public function setMenus()
	{
		if($this->container->hasParameter('theme.menus'))
		{
			$menus = $this->container->getParameter('theme.menus');
			$this->menus = $this->container->get('menus');
			$this->menus->addMenus($menus);
		}
	}

	/** 
	 * Setup theme support.
	 */
	public function setSupport()
	{
		if($this->container->hasParameter('theme.supports'))
		{
			$supports = $this->container->getParameter('theme.supports');
			$this->support = new SupportManager();
			$this->support->addSupports($supports);
		}
	}

	/**
	 * Setup theme sidebars.
	 */
	public function setSidebars()
	{
		if($this->container->hasParameter('theme.sidebars'))
		{
			$sidebars = $this->container->getParameter('theme.sidebars');
			$this->sidebars = $this->container->get('sidebars');
			$this->sidebars->addSidebars($sidebars);
		}
	}

	/**
	 * Set the cache.
	 */
	private function setCache()
	{
		$this->cache = new Cache('soda');
	}

	/**
	 * Setup the container.
	 */
	private function setContainer()
	{
		$config = dirname(__FILE__) . '/Config';
		$cache = WP_CONTENT_DIR . '/cache/container.php';

		if ($this->isDebug() && file_exists($cache) && $this->cache->hasKey('containercache'))
		{
			include($cache);
			$this->container = new \ThemeCache();
		}
		else
		{
			$this->container = new ContainerBuilder();
			
			$extension = new ThemeConfigExtension();
			$this->container->registerExtension($extension);
			$this->container->loadFromExtension($extension->getAlias());

			$loader = new YamlFileLoader($this->container, new FileLocator($config));
			$loader->load('services.yml');
			$this->container->compile();

		    $dumper = new PhpDumper($this->container);
		    file_put_contents($cache, $dumper->dump(['class' => 'ThemeCache']));
		    $this->cache->set('containercache', true);
		}
	}
}