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
 * Yapi Memcache Caching Class
 *
**/

require_once('YapiCache.class.php');

class YapiCacheMemcache extends YapiCache
{
    var $iTTL = 3600; 
    var $iStoreFlag = 0; 
    var $oMemcache = null;

	protected $aServers = array(
					'default' => array(
						'host'		=> '127.0.0.1',
						'port'		=> 11211,
						'weight'	=> 1
					)
				);
	/**
	 * constructor
	 */
	function YapiCacheMemcache()
	{
	    parent::YapiCache();
        if (class_exists('Memcache'))
		{
            $this->oMemcache = new Memcache;
            if (!$this->oMemcache->connect ($this->aServers['default']['host'], $this->aServers['default']['port'])) 
                $this->oMemcache = null;
        }
	}

	/**
	 * Get all data from the cache file.
	 *
	 * @param string $sKey - file name
     * @param int $iTTL - time to live
	 * @return the data is got from cache.
	 */
	function getData($sKey, $iTTL = false)
	{    
        $data = $this->oMemcache->get($sKey);
		return false === $data ? null : $data;
	}

	/**
	 * Save all data in cache file.
	 *
	 * @param string $sKey - file name
	 * @param mixed $data - the data to be cached in the file
     * @param int $iTTL - time to live
	 * @return boolean result of operation.
	 */
	function setData($sKey, $data, $iTTL = false)
	{
        return $this->oMemcache->set($sKey, $data, $this->iStoreFlag, false === $iTTL ? $this->iTTL : $iTTL);
	}

	/**
	 * Delete cache file.
	 *
	 * @param string $sKey - file name
	 * @return result of the operation
	 */
    function delData($sKey)
	{
        $this->oMemcache->delete($sKey);
        return true;
    }

    /**
     * Check if eAccelerator is available
     * @return boolean
     */
    function isAvailable()
	{
        return $this->oMemcache == null ? false : true;
    }

	/**
	 * Check if memcache extension is loaded
	 * @return boolean
	 */
    function isInstalled() {
        return extension_loaded('memcache');
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
     * add Memcache servers
     */
    function addServer($sHost, $iPort = 11211, $iWeight = 10)
	{
        $this->oMemcache->addServer($sHost, $iPort, true, $iWeight);
    }

	/**
	 * removes all values from cache.
	 * @return true on success
	 */
	function flush()
	{
		return $this->oMemcache->flush();
	}
}