<?php

namespace Soda\Component\MenuManager;

use Soda\Component\Translator\Translator;
use Soda\Component\SupportManager\SupportManager;

/**
 * Menu Manager Class.
 *
 * The Menu Manager Class sets up our theme navigation menus.
 *
 * @package    Soda Standard Edition
 * @author     Drew Morris <drewsy.morris@gmail.com>
 * @copyright  2014 Drew Morris
 * @license    MIT
 * @since      1.0
 */
class MenuManager
{
	/**
	 * Add theme menus.
	 * @param array $menus Array of menus to add.
	 */
	public function addMenus(array $menus)
	{
		foreach($menus as $key => $value)
		{
			register_nav_menu($key, $this->translator->t($value, true));
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