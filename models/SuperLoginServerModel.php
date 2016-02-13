<?php

/**
 * Contao Open Source CMS
 *
 * Copyright (c) 2005-2014 Leo Feyer
 *
 * @package   SuperLogin
 * @author    Hendrik Obermayer - Comolo GmbH
 * @license   -
 * @copyright 2014 Hendrik Obermayer
 */


/**
 * Namespace
 */
namespace SuperLogin;

/**
 * Class AuthServerModel
 *
 * @copyright  2014 Hendrik Obermayer
 * @author     Hendrik Obermayer - Comolo GmbH
 * @package    Devtools
 */
class SuperLoginServerModel extends \Model
{

	/**
	 * Name of the table
	 * @var string
	 */
	protected static $strTable = 'tl_superlogin_server';


    public function getRedirectUrl()
    {
        $base = \Environment::get('requestUri');
        $delimiter = '&';

        if (str_replace('?', '', $base) === $base) {
            $delimiter = '?';
        }

        return $base . $delimiter . 'superlogin=' . $this->id;
    }

}

/*
* Fix autoload bug
*/
class_alias('SuperLogin\SuperLoginServerModel', '\SuperLoginServerModel');