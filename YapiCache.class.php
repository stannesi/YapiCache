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
 * Yapi Caching Class
 *
 * YapiCache.class is the base class for cache classes with different cache storage implementation.
 *
**/

require_once('YapiError.class.php');

class YapiCache extends YapiError
{
	/**
	 * constructor
	 */
	function Cache()
	{
	    parent::Error();
	}

	/**
	 * Is cache engine available?
	 * @return boolean
	 */
    function isAvailable()
	{
        return true;
    }

	/**
	 * Are required php modules are installed for this cache engine ?
	 * @return boolean
	 */
    function isInstalled()
	{
        return true;
    }

	function getData($sKey, $iTTL = false) {}
	function setData($sKey, $data, $iTTL = false) {}
    function delData($sKey) {}
    function removeAllByPrefix ($s) {}

    function flush()
	{
		return true;
	}
}