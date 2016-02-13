<?php

/**
 * Contao Open Source CMS
 *
 * Copyright (c) 2005-2014 Leo Feyer
 *
 * @package Auth_client
 * @link    https://contao.org
 * @license http://www.gnu.org/licenses/lgpl-3.0.html LGPL
 */


/**
 * Register the templates
 */
TemplateLoader::addFiles(array
(
	'mod_superlogin_loginpage' => 'system/modules/superlogin-client/templates',
));


/**
 * Register the namespaces
 */
ClassLoader::addNamespaces(array
(
    'SuperLogin',
));

/**
 * Register the classes
 */
ClassLoader::addClasses(array
(
    // Classes
    'SuperLogin\ClcPlusAuthProvider' => 'system/modules/superlogin-client/classes/ClcPlusAuthProvider.php',
    'SuperLogin\LoginAuth'       => 'system/modules/superlogin-client/classes/LoginAuth.php',
    'SuperLogin\AuthProvider'    => 'system/modules/superlogin-client/classes/AuthProvider.php',
    'SuperLogin\tl_authclient_server'    => 'system/modules/superlogin-client/classes/tl_authclient_server.php',
    'SuperLogin\DisplayAuthProviders'    => 'system/modules/superlogin-client/classes/DisplayAuthProviders.php',

    // Models
    'SuperLogin\SuperLoginServerModel' => 'system/modules/superlogin-client/models/SuperLoginServerModel.php',
));