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
 * Yapi EAccelerator Caching Class
 *
**/

require_once('YapiCache.class.php');

class YapiCacheEAccelerator extends YapiCache
{
    var $iTTL = 3600;
	/**
	 * constructor
	 */
	function YapiCacheEAccelerator()
	{
	    parent::YapiCache();
	}

	/**
	 * Get data from shared memory cache
	 *
	 * @param string $sKey - file name
     * @param int $iTTL - time to live
	 * @return the data is got from cache.
	 */
	function getData($sKey, $iTTL = false)
	{    
        $sData = eaccelerator_get($sKey);
		return null === $sData ? null : unserialize($sData);
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
        return eaccelerator_put($sKey, serialize($data), false === $iTTL ? $this->iTTL : $iTTL);
	}

	/**
	 * Delete cache from shared memory
	 *
	 * @param string $sKey - file name
	 * @return result of the operation
	 */
    function delData($sKey)
	{
        eaccelerator_lock($sKey);
        
        eaccelerator_rm($sKey);
        
        eaccelerator_unlock($sKey);
        
        return true;
    }

    /**
     * Check if eAccelerator is available
     * @return boolean
     */
    function isAvailable()
	{
		return function_exists('eaccelerator_put');
    }

	/**
	 * Check if eaccelerator extension is loaded
	 * @return boolean
	 */
    function isInstalled()
	{
        return extension_loaded('eaccelerator');
    }

    /**
     * remove all data from cache by key prefix
     * @return true on success
     */
    function removeAllByPrefix ($s)
	{
        $l = strlen($s);
        $aKeys = eaccelerator_list_keys(); 
        foreach ($aKeys as $aKey) {
            $sKey = 0 === strpos($aKey['name'], ':') ? substr($aKey['name'], 1) : $aKey['name'];
            if (0 == strncmp($sKey, $s, $l))
                $this->delData($sKey);
        }
        return true;
    }

	/**
	 * removes all values from cache.
	 * @return true on success
	 */
	function flush()
	{
		// first, remove expired content from cache
		eaccelerator_gc();
		// now, remove leftover cache-keys
		$aKeys = eaccelerator_list_keys();
		
		foreach($aKeys as $aKey)
			$this->delData(substr($aKey['name'], 1));
		return true;
	}
}