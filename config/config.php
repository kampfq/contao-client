<?php

/**
 * Contao Open Source CMS
 *
 * Copyright (c) 2005-2014 Leo Feyer
 *
 * @package   AuthClient
 * @author    Hendrik Obermayer - Comolo GmbH
 * @license   -
 * @copyright 2014-2015 Hendrik Obermayer
 */

// Initialize global AUTH_CLIENT array
$GLOBALS['AUTH_CLIENT'] = array();
$GLOBALS['AUTH_CLIENT']['providers'] = array();

// Add CLC Provider
$GLOBALS['AUTH_CLIENT']['providers'][] = 'ClcPlusAuthProvider';
$GLOBALS['AUTH_CLIENT']['version'] = '2';
$GLOBALS['AUTH_CLIENT']['type'] = '5';

$GLOBALS['TL_HOOKS']['checkCredentials'][] = array('LoginAuth', 'loginUserHookPassword');
$GLOBALS['TL_HOOKS']['initializeSystem'][] = array('LoginAuth', 'listenForAuthResponse');
$GLOBALS['TL_HOOKS']['initializeSystem'][] = array('LoginAuth', 'listenForAuthRequest');
$GLOBALS['TL_HOOKS']['parseBackendTemplate'][] = array('LoginAuth', 'addServersToLoginPage');

$GLOBALS['BE_MOD']['system']['auth_client'] = array(
    'tables'       => array('tl_authclient_server'),
    'icon'         => 'system/modules/auth_client/assets/computer_key.png',
);

$GLOBALS['BE_FFL']['infobox'] = 'InfoboxField';

$GLOBALS['TL_CONFIG']['authClientCertificateFiletype'] = 'superlogin';

// Allow upload of certificate files
if (!in_array(
    $GLOBALS['TL_CONFIG']['authClientCertificateFiletype'],
    explode(',', $GLOBALS['TL_CONFIG']['uploadTypes']))
) {
    $GLOBALS['TL_CONFIG']['uploadTypes'] .= ',' . $GLOBALS['TL_CONFIG']['authClientCertificateFiletype'];
}
