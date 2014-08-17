<?php

namespace Soda\Component\AssetManager;

/**
 * Asset Manager Class.
 *
 * The Asset Manager Class implements the scripts and styles in our theme.
 *
 * @package    Soda Standard Edition
 * @author     Drew Morris <drewsy.morris@gmail.com>
 * @copyright  2014 Drew Morris
 * @license    MIT
 * @since      1.0
 */
class AssetManager
{
	/**
	 * Setup our asset manager.
	 * @param string $path Template directory path.
	 * @param string $uri  Template directory uri.
	 */
	public function __construct($path, $uri)
	{	
		$this->path = $path;
		$this->uri = $uri;
	}

	/**
	 * Add multple theme styles.
	 * @param array $styles Array of styles to add.
	 */
	public function addStyles(array $styles)
	{
		foreach($styles as $key => $value)
		{
			wp_enqueue_style(
				$key,
				esc_url(trailingslashit($this->uri) . $value[0]),
				isset($value[1]) ? $value[1] : null,
				isset($value[2]) ? $value[2] : null,
				isset($value[3]) ? $value[3] : null
			);
		}
	}

	/**
	 * Add multiple theme scripts.
	 * @param array $scripts Array of scripts to add.
	 */
	public function addScripts(array $scripts)
	{
		foreach($scripts as $key => $value)
		{
			if(wp_script_is($key, 'registered'))
				wp_deregister_script($key);

			$src = parse_url($value[0]);

			if(!array_key_exists('scheme', $src))
				$value[0] = trailingslashit($this->uri) . $value[0];

			wp_enqueue_script(
				$key,
				esc_url($value[0]),
				isset($value[1]) ? $value[1] : null,
				isset($value[2]) ? $value[2] : null,
				isset($value[3]) ? $value[3] : null
			);
		}
	}
}