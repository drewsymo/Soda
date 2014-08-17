<?php

namespace Soda\Component\Cache;

/**
 * Cache Class.
 *
 * The Cache Class is a wrapper for the WP_Object_Cache.
 *
 * @package    Soda Standard Edition
 * @author     Drew Morris <drewsy.morris@gmail.com>
 * @copyright  2014 Drew Morris
 * @license    MIT
 * @since      1.0
 */
class Cache
{
	/**
	 * Group namespace for the cache.
	 * @var string
	 */
	protected $group;

	/**
	 * Initializes the class and sets up the group.
	 */
	public function __construct($group = null)
	{
		$this->group = sanitize_key($group);
	}

	/**
	 * Adds a key to the cache.
	 * @param string $key    Key to add.
	 * @param array $data    Data for key.
	 * @param string $expire TTL.
	 */
	public function add($key, $data, $expire = null)
	{
		wp_cache_add($key, $data, $this->group, $expire);
	}

	/**
	 * Sets a key in the cache.
	 * @param string $key    Key to add.
	 * @param array $data    Data for key.
	 * @param string $expire TTL.
	 */
	public function set($key, $data, $expire = null)
	{
		wp_cache_set($key, $data, $this->group, $expire);
	}

	/**
	 * Retrieves a key from the cache.
	 * @param  string  $key Key to retrieve.
	 */
	public function get($key)
	{
		$result = wp_cache_get($key, $this->group);

		if($result)
			return $result;

		return false;
	}

	/**
	 * Flushes the object cache.
	 */
	public function flush()
	{
		wp_cache_flush();
	}

	/**
	 * Checks if the cache group has a key.
	 * @param  string  $key Key to retrieve.
	 */
	public function hasKey($key)
	{
		if($this->get($key))
			return true;

		return false;
	}
}