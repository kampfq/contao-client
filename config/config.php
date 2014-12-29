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

// Initialize global AUTH_CLIENT array
$GLOBALS['AUTH_CLIENT'] = array();
$GLOBALS['AUTH_CLIENT']['providers'] = array();

// Add CLC Provider
$GLOBALS['AUTH_CLIENT']['providers'][] = 'ClcAuthProvider';

$GLOBALS['BE_MOD']['system']['auth_client'] = array(
    'tables'       => array('tl_authclient_server'),
    'icon'         => 'system/modules/auth_client/assets/computer_key.png',
);

$GLOBALS['TL_HOOKS']['checkCredentials'][] = array('LoginAuth', 'loginUserHookPassword');
$GLOBALS['TL_HOOKS']['initializeSystem'][] = array('LoginAuth', 'listenForAuthResponse');
$GLOBALS['TL_HOOKS']['initializeSystem'][] = array('LoginAuth', 'listenForAuthRequest');
$GLOBALS['TL_HOOKS']['parseBackendTemplate'][] = array('LoginAuth', 'addServersToLoginPage');
