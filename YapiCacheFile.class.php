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
 * Yapi File Caching Class
 *
**/

require_once('YapiCache.class.php');

class YapiCacheFile extends YapiCache
{
    var $sPath;
	/**
	 * constructor
	 */
	function YapiCacheFile()
	{
	    parent::YapiCache();
		$this->sPath = DIR_PATH_DBCACHE;
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

	    include($this->sPath . $sKey);
	    return $data;
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

        fwrite($rHandler, '<?php $data=' . var_export($data, true) . '; ?>');
        fclose($rHandler);
        @chmod($this->sPath . $sKey, 0666);

        return true;
	}

	/**
	 * Delete cache file.
	 *
	 * @param string $sKey - file name
	 * @return result of the operation
	 */
    function delData($sKey)
	{
        $sFile = $this->sPath . $sKey;
        return !file_exists($sFile) || @unlink($sFile);
    }

    /**
     * remove all data from cache by key prefix
     * @return true on success
     */
    function removeAllByPrefix ($s)
	{        
        if (!($rHandler = opendir($this->sPath))) 
            return false;

        $l = strlen($s);
        while (($sFile = readdir($rHandler)) !== false)
            if (0 == strncmp($sFile, $s, $l))
                @unlink ($this->sPath . $sFile);
        
        closedir($rHandler);

        return true;
    }

    /**
     * remove file from dist if TTL expored
     * @param string $sFile - full path to filename
     * @param int $iTTL - time to live in seconds
     * @return true if TTL is expired and file is deleted or false otherwise
     */
    function _removeFileIfTtlExpired ($sFile, $iTTL)
	{
        $iTimeDiff = time() - filectime($sFile);
        if ($iTimeDiff > $iTTL) {
            @unlink ($sFile);
            return true;
        } else {
            return false;  
        }
    }

	/**
	 * removes all values from cache.
	 * @return true on success
	 */
	function flush()
	{
       if (!($rHandler = opendir($this->sPath))) 
            return false;

        while (($sFile = readdir($rHandler)) !== false)
                @unlink ($this->sPath . $sFile);
        
        closedir($rHandler);

        return true;
	}
}