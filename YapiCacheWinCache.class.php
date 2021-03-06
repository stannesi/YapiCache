<?php
/***************************************************************************
*                          Yapi Inc.
*                          -----------------
*     begin                : Dec 24 2010
*     copyright            : (C) 2010 Yapi Inc.
*     website              : http://www.yapi.com/
*
*
* @author		Stanley Ilukhor (stan nesi) <stannesi@yahoo.com>
* @copyright	Copyright (c) 2011 Yapi Inc.
* @license		http://codeigniter.com/user_guide/license.html
* @link			http://yapi.com/
***************************************************************************/

/**
 * Yapi WinCache Caching Class
 *
**/

require_once('YapiCache.class.php');

class YapiCacheWinCache extends YapiCache
{
    var $iTTL = 3600;
	/**
	 * constructor
	 */
	function YapiCacheWinCache()
	{
	    parent::YapiCache();
	}

	/**
	 * Get data from shared memory cache.
	 *
	 * @param string $sKey - file name
     * @param int $iTTL - time to live
	 * @return the data is got from cache.
	 */
	function getData($sKey, $iTTL = false)
	{
		return wincache_ucache_get($key);
	}

	/**
	 * Save data in shared memory cache
	 *
	 * @param string $sKey - file name
	 * @param mixed $data - the data to be cached in the file
     * @param int $iTTL - time to live
	 * @return boolean result of operation.
	 */
	function setData($sKey, $data, $iTTL = false)
	{
        return wincache_ucache_set($sKey, $data, false === $iTTL ? $this->iTTL : $iTTL);
	}

	/**
	 * Delete cache file.
	 *
	 * @param string $sKey - file name
	 * @return result of the operation
	 */
    function delData($sKey)
	{
		return wincache_ucache_delete($sKey);
    }

    /**
     * Check if APC is available
     * @return boolean
     */
    function isAvailable()
	{
        return function_exists('wincache_ucache_set');
    }

	/**
	 * Check if apc extension is loaded
	 * @return boolean
	 */
    function isInstalled() {
        return extension_loaded('wincache');
    }

    /**
     * remove all data from cache by key prefix
     * @return true on success
     */
    function removeAllByPrefix ($s)
	{
        // not implemented for current cache
        return false;
    }

	/**
	 * removes all values from cache.
	 * @return true on success
	 */
	function flush()
	{
		return wincache_ucache_clear();
	}
}