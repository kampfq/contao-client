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
    'SuperLogin\tl_superlogin_server'    => 'system/modules/superlogin-client/classes/tl_superlogin_server.php',
    'SuperLogin\DisplayAuthProviders'    => 'system/modules/superlogin-client/classes/DisplayAuthProviders.php',
    'SuperLogin\AuthorizationHelper'    => 'system/modules/superlogin-client/classes/AuthorizationHelper.php',
    'SuperLogin\AuthorizationController'       => 'system/modules/superlogin-client/classes/AuthorizationController.php',
    'SuperLogin\OAuth2Provider'    => 'system/modules/superlogin-client/classes/OAuth2Provider.php',

    // Models
    'SuperLogin\SuperLoginServerModel' => 'system/modules/superlogin-client/models/SuperLoginServerModel.php',
));