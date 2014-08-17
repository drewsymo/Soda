<?php

namespace Soda\Component\SidebarManager;

use Soda\Component\Translator\Translator;

/**
 * Sidebar Manager Class.
 *
 * The Sidebar Manager Class sets up our theme sidebars.
 *
 * @package    Soda Standard Edition
 * @author     Drew Morris <drewsy.morris@gmail.com>
 * @copyright  2014 Drew Morris
 * @license    MIT
 * @since      1.0
 */
class SidebarManager
{
	/**
	 * Add theme sidebars.
	 * @param array $sidebars Array of sidebars to add.
	 */
	public function addSidebars(array $sidebars)
	{
		foreach($sidebars as $key => $value)
		{
			$value['id'] = $key;
			
			if(isset($value['name']))
				$value['name'] = $this->translator->t($value['name'], true);

			if(isset($value['description']))
				$value['description'] = $this->translator->t($value['description'], true);

			register_sidebar($value);
		}
	}

	/**
	 * Set the translator.
	 * @param Translator $translator Theme translator.
	 */
	public function setTranslator(Translator $translator)
	{
		$this->translator = $translator;
	}
}