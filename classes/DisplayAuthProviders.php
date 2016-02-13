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
namespace SuperLogin;

/**
 * Class LoginAuth
 *
 * @copyright  2014 Hendrik Obermayer
 * @author     Hendrik Obermayer - Comolo GmbH
 * @package    Devtools
 */
class DisplayAuthProviders extends \System
{
    /**
     * Display option field in backend login
     *
     * @param $strContent
     * @param $strTemplate
     * @return mixed
     */
	public function addServersToLoginPage($strContent, $strTemplate)
    {
        if ($strTemplate == 'be_login')
        {
            $template = new \BackendTemplate('mod_superlogin_loginpage');
            $template->loginServers = SuperLoginServerModel::findAll();

            // TODO: Check if server is enabled
            $searchString = '<div id="tl_license">';
            $strContent = str_replace($searchString, $template->parse().$searchString, $strContent);
            
            // Add CSS
            $searchString = '</head>';
            $cssLink = '<link rel="stylesheet" href="/system/modules/superlogin-client/assets/css/superlogin.css">';
            $strContent = str_replace($searchString, $cssLink.$searchString, $strContent);
        }

        return $strContent;
    }
}
