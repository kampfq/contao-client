<?php

/**
 * Contao Open Source CMS
 *
 * Copyright (c) 2005-2014 Leo Feyer
 *
 * @package   AuthClient
 * @author    Hendrik Obermayer - Comolo GmbH
 * @license   -
 * @copyright 2014 Hendrik Obermayer
 */


/**
 * Namespace
 */
namespace Comolo\SuperLoginClient\ContaoEdition\Model;
use  Comolo\SuperLoginClient\ContaoEdition\AuthProvider\OAuth2Provider;

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
        $provider = \System::getContainer()->get('superlogin.server_manager')->createOAuth2Provider($this);
        $authorizationUrl = $provider->getAuthorizationUrl();
        \System::getContainer()->get('session')->set('oauth2state', $provider->getState());
        
        return  $authorizationUrl;
    }

}

/*
 * Fix autoload bug
 */
class_alias('Comolo\SuperLoginClient\ContaoEdition\Model\SuperLoginServerModel', '\SuperLoginServerModel');