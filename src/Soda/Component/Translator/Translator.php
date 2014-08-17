<?php

namespace Soda\Component\Translator;

/**
 * Translator Class.
 *
 * The Translator Class loads our theme textdomain and provides a wrapper
 * for the WordPress i18n functions.
 * 
 * @package    Soda Standard Edition
 * @author     Drew Morris <drewsy.morris@gmail.com>
 * @copyright  2014 Drew Morris
 * @license    MIT
 * @since      1.0
 */
class Translator
{
	protected $textdomain;

	/**
	 * Setup the textdomain and path.
	 * @param string $path       Path to template directory.
	 * @param string $textdomain Textdomain to use.
	 */
	public function __construct($path, $textdomain)
	{
		$this->path = $path;
		$this->textdomain = $textdomain;
		
		$this->loadTextdomain();
	}

	/**
	 * Loads our theme textdomain.
	 */
	public function loadTextdomain()
	{
		if(is_child_theme())
		{
			load_child_theme_textdomain($this->textdomain, trailingslashit($this->path) . '/languages');
		}
		else
		{
			load_theme_textdomain($this->textdomain, trailingslashit($this->path) . '/languages');
		}
	}

	/**
	 * Displays the translated text.
	 * @param string $string String to translate.
	 */
	public function t($string, $return = false)
	{
		if(!$return)
		{
			_e($string, $this->textdomain);
		}
		else
		{
			return __($string, $this->textdomain);
		}
	}

	/**
	 * Displays the translated singluar or plural text.
	 * @param string $single The text that will be used if $number is 1.
	 * @param string $plural The text that will be used if $number is not 1.
	 * @param int    $number The number to compare against to use either $single or $plural.
	 */
	public function _n($single, $plural, $number)
	{
		_n($single, $plural, $number, $this->textdomain);
	}
}