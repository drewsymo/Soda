<?php

namespace Soda\Component\SupportManager;

/**
 * Support Manager Class.
 *
 * The Support Manager Class sets up our theme support definitions.
 *
 * @package    Soda Standard Edition
 * @author     Drew Morris <drewsy.morris@gmail.com>
 * @copyright  2014 Drew Morris
 * @license    MIT
 * @since      1.0
 */
class SupportManager
{
	/**
	 * Add multiple theme support definitions.
	 * @param array $supports Array of theme support definitions to add.
	 */
	public function addSupports(array $supports)
	{
		foreach($supports as $key => $attributes)
		{
			$this->addSupport($key, $attributes);
		}
	}

	/**
	 * Add theme support.
	 * @param string $key        Theme support key.
	 * @param array  $attributes Theme support attributes.
	 */
	public function addSupport($key, array $attributes)
	{
		add_theme_support($key, $attributes);
	}
}