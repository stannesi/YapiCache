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
 * Yapi APC Caching Class
 *
**/

require_once('YapiCache.class.php');

class YapiCacheAPC extends YapiCache
{
    var $iTTL = 3600;
	/**
	 * constructor
	 */
	function YapiCacheAPC()
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
        $isSucess = false;
	
        $data = apc_fetch ($sKey, $isSucess);
		
        if (!$isSucess)
            return null;

		return $data;
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
        return apc_store ($sKey, $data, false === $iTTL ? $this->iTTL : $iTTL);
	}

	/**
	 * Delete cache file.
	 *
	 * @param string $sKey - file name
	 * @return result of the operation
	 */
    function delData($sKey)
	{
		$isSucess = false;
		apc_fetch ($sKey, $isSucess);
		
		if (!$isSucess)
            return true;

        return apc_delete($sKey);
    }

    /**
     * Check if APC is available
     * @return boolean
     */
    function isAvailable()
	{
        return function_exists('apc_store');
    }

	/**
	 * Check if apc extension is loaded
	 * @return boolean
	 */
    function isInstalled() {
        return extension_loaded('apc');
    }

    /**
     * remove all data from cache by key prefix
     * @return true on success
     */
    function removeAllByPrefix ($s)
	{
       $l = strlen($s);
        $aKeys = apc_cache_info('user'); 
        if (isset($aKeys['cache_list']) && is_array($aKeys['cache_list'])) {
            foreach ($aKeys['cache_list'] as $r) {
                $sKey = $r['info'];
                if (0 == strncmp($sKey, $s, $l))
                    $this->delData($sKey);
            }
        }
        return true;
    }

	/**
	 * removes all values from cache.
	 * @return true on success
	 */
	function flush()
	{
		return apc_clear_cache('user');
	}
}