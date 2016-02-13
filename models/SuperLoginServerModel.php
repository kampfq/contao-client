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
        return \System::getContainer()->get('router')
                ->generate('superlogin_auth_redirect', array('serverId' => $this->id));
    }

}