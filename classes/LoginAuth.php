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
namespace AuthClient;


/**
 * Class LoginAuth
 *
 * @copyright  2014 Hendrik Obermayer
 * @author     Hendrik Obermayer - Comolo GmbH
 * @package    Devtools
 */
class LoginAuth extends \System
{
    protected static $allowLogin = false;
    protected $serverId = null;

    /**
     * remember the last used login provider
     */
    protected function setPreferredLoginProvider()
    {
        if ($this->serverId) {
            unset($_COOKIE['cto_preferred_login_provider']);
            $this->setCookie('cto_preferred_login_provider', $this->serverId, time()+60*60*24*30);
        }
    }

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
            $template = new \BackendTemplate('mod_authclient_serverlist');
            $template->loginServers = \AuthClientServerModel::findAll();

            // TODO: Check if certificate is still valid

            // Preferred login provider
            $preferredServer = intval(\Input::cookie('cto_preferred_login_provider'));
            if ($preferredServer > 0) {
                $template->preferredServer = $preferredServer;
            }
            else {
                $template->preferredServer = false;
            }

            $searchString = '<table class="tl_login_table">';
            $strContent = str_replace($searchString, $searchString . $template->parse(), $strContent);
        }

        return $strContent;
    }

    /**
     * check for a new request to redirect to the auth server
     * @return bool|void
     */
    public function listenForAuthRequest()
    {
        // run only in be mode
        if (TL_SCRIPT != 'contao/index.php' || TL_MODE != 'BE') return;
        
        // Initialize BackendUser before Database
        \BackendUser::getInstance();
        \Database::getInstance();  

        $this->serverId = $serverId = intval(\Input::post('auth_server'));

        if ($serverId > 0) {

            $server = \AuthClientServerModel::findById($serverId);
            if(!$server) return false;

            $class = $server->auth_provider;

            $authProvider = new $class();
            $authProvider->setAuthServerId($serverId);
            $authProvider->setServerAddress($server->server_address);
            $authProvider->setPublicId($server->public_id);
            $authProvider->setPrivateKey($server->private_key);
            $authProvider->setServerKey($server->server_key);
            $authProvider->run();

            return true;
        }

        return false;
    }

    /**
     * check for incoming request from the clc server
     * @return bool|void
     */
    public function listenForAuthResponse()
    {

        // run only in be mode
        if (TL_SCRIPT != 'contao/index.php' || TL_MODE != 'BE') return;
        
        // Initialize BackendUser before Database
        \BackendUser::getInstance();
        \Database::getInstance();  

        $this->serverId = $serverId = intval(\Input::get('authid'));

        if ($serverId > 0) {

            $server = \AuthClientServerModel::findById($serverId);
            if(!$server) return false;

            $class = $server->auth_provider;

            $authProvider = new $class();
            $authProvider->setAuthServerId($serverId);
            $authProvider->setServerAddress($server->server_address);
            $authProvider->setPublicId($server->public_id);
            $authProvider->setPrivateKey($server->private_key);
            $authProvider->setServerKey($server->server_key);

            // Fix: temporarily disable request token
            $tokenStatus = $GLOBALS['TL_CONFIG']['disableRefererCheck'];
            $GLOBALS['TL_CONFIG']['disableRefererCheck'] = false;

            // TODO: check for exception / display error
            $response = $authProvider->checkResponse();

            // reset request token status
            $GLOBALS['TL_CONFIG']['disableRefererCheck'] = $tokenStatus;

            if($response) {
                $this->loginUser($response);
            }

            return true;
        }

        return false;
    }

    /**
     * try to log the user in
     *
     * @param $userData
     * @return bool
     */
    protected function loginUser($userData)
    {
        if (!is_array($userData) || !isset($userData['username'])) return false;

        $user = \UserModel::findByUsername($userData['username']);

        // Create new user
        if (!$user) {
            $user = new \UserModel();
            $user->tstamp = time();
            $user->uploader = 'FileUpload';
            $user->backendTheme = 'default';
            $user->dateAdded = time();

            $user->showHelp = true;
            $user->thumbnails = true;
            $user->useRTE = true;
            $user->useCE = true;

            $user->username = $userData['username'];
        }

        // Update general user data
        $user->name = $userData['name'];
        $user->email = $userData['email'];
        $user->language = (isset($userData['language'])) ? $userData['language'] : null;
        $user->admin = (isset($userData['admin']) && $userData['admin'] == "1") ? true : false;

        // Save user
        $user->save();

        // Perform frontend login
        self::$allowLogin = true;
        $_POST['username'] = $user->username;
        $_POST['password'] = '#######';
        $_POST['REQUEST_TOKEN'] = REQUEST_TOKEN;

        $this->setPreferredLoginProvider();
        $this->loginUserAction();
    }

    /**
     * helper method - user login
     */
    protected function loginUserAction()
    {
        $this->import('BackendUser', 'User');

        // Login
        if ($this->User->login())
        {
            $strUrl = 'contao/main.php';

            // Redirect to the last page visited
            if (\Input::get('referer', true) != '')
            {
                $strUrl = base64_decode(\Input::get('referer', true));
            }

            $this->redirect($strUrl);
        }
    }

    /**
     * helper method - user login
     *
     * @param $strUsername
     * @param $strPassword
     * @param $objUser
     * @return bool
     */
    public function loginUserHookPassword($strUsername, $strPassword, $objUser)
    {
        if (self::$allowLogin) {
            return true;
        }

        return false;
    }
}
