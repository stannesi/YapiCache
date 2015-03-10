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
 * Yapi XCache Caching Class
 *
**/

require_once('YapiCache.class.php');

class YapiCacheXCache extends YapiCache
{
    var $iTTL = 3600;
	/**
	 * constructor
	 */
	function YapiCacheXCache()
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
		if (!xcache_isset($sKey))
			return null;

		return xcache_get($sKey);
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
        return xcache_set($sKey, $data, false === $iTTL ? $this->iTTL : $iTTL);
	}

	/**
	 * Delete cache file.
	 *
	 * @param string $sKey - file name
	 * @return result of the operation
	 */
    function delData($sKey)
	{
		if (!xcache_isset($sKey))
			return true;

		return xcache_unset($sKey);
    }

    /**
     * Check if APC is available
     * @return boolean
     */
    function isAvailable()
	{
        return function_exists('xcache_set');
    }

	/**
	 * Check if apc extension is loaded
	 * @return boolean
	 */
    function isInstalled() {
        return extension_loaded('xcache');
    }

    /**
     * remove all data from cache by key prefix
     * @return true on success
     */
    function removeAllByPrefix ($s)
	{
		return xcache_unset_by_prefix ($s);
    }

	/**
	 * removes all values from cache.
	 * @return true on success
	 */
	function flush()
	{
		for($i=0, $max=xcache_count(XC_TYPE_VAR); $i<$max; $i++)
		{
			if(xcache_clear_cache(XC_TYPE_VAR, $i)===false)
				return false;
		}
		return true;
	}
}