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
 * Yapi FileHTML Caching Class
 *
**/

require_once('YapiCacheFile.class.php');

class YapiCacheFileHtml extends YapiCacheFile
{
    var $sPath;
	/**
	 * constructor
	 */
	function YapiCacheFileHtml()
	{
	    parent::YapiCacheFile();
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
		if (!file_exists($this->sPath . $sKey)) 
			return null;

        if ($iTTL > 0 && $this->_removeFileIfTtlExpired ($this->sPath . $sKey, $iTTL))
            return null;

		return file_get_contents($this->sPath . $sKey);
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
	    if(file_exists($this->sPath . $sKey) && !is_writable($this->sPath . $sKey))
	       return false;

	    if(!($rHandler = fopen($this->sPath . $sKey, 'w'))) 
	       return false;

        fwrite($rHandler, $data);
        fclose($rHandler);
        @chmod($this->sPath . $sKey, 0666);

        return true;
	}
}