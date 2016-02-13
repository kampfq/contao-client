<?php

/**
 * Contao Open Source CMS
 *
 * Copyright (c) 2005-2014 Leo Feyer
 *
 * @package   SuperLogin
 * @author    Hendrik Obermayer - Comolo GmbH
 * @license   -
 * @copyright 2014-2016 Hendrik Obermayer
 */

$GLOBALS['TL_HOOKS']['parseBackendTemplate'][] = array('DisplayAuthProviders', 'addServersToLoginPage');

$GLOBALS['TL_HOOKS']['checkCredentials'][] = array('LoginAuth', 'loginUserHookPassword');
$GLOBALS['TL_HOOKS']['initializeSystem'][] = array('LoginAuth', 'listenForAuthResponse');
$GLOBALS['TL_HOOKS']['initializeSystem'][] = array('LoginAuth', 'listenForAuthRequest');
$GLOBALS['TL_HOOKS']['parseBackendTemplate'][] = array('LoginAuth', 'addServersToLoginPage');


$GLOBALS['BE_MOD']['superlogin']['superlogin_auth_servers'] = array(
    'tables'       => array('tl_superlogin_server'),
    'icon'         => '/system/modules/superlogin-client/assets/img/icon.png',
);