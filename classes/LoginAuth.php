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

	public function addServersToLoginPage($strContent, $strTemplate)
    {
        if ($strTemplate == 'be_login')
        {
            $template = new \BackendTemplate('mod_authclient_serverlist');
            $template->loginServers = \AuthClientServerModel::findAll();

            $searchString = '<table class="tl_login_table">';
            $strContent = str_replace($searchString, $searchString . $template->parse(), $strContent);
        }

        return $strContent;
    }

    public function listenForAuthRequest()
    {
        // run only in be mode
        if(TL_SCRIPT != 'contao/index.php' || TL_MODE != 'BE') return;

        $serverId = intval(\Input::post('auth_server'));

        if($serverId > 0) {

            $server = \AuthClientServerModel::findById($serverId);
            if(!$server) return false;

            $class = $server->auth_provider;

            $authProvider = new $class();
            $authProvider->setAuthServerId($serverId);
            $authProvider->setServerAddress($server->server_address);
            $authProvider->setPublicId($server->public_id);
            $authProvider->setPrivateKey($server->private_key);
            $authProvider->run();

            return true;
        }

        return false;
    }

    public function listenForAuthResponse()
    {
        // run only in be mode
        if(TL_SCRIPT != 'contao/index.php' || TL_MODE != 'BE') return;

        $serverId = intval(\Input::get('authid'));

        if($serverId > 0) {

            $server = \AuthClientServerModel::findById($serverId);
            if(!$server) return false;

            $class = $server->auth_provider;

            $authProvider = new $class();
            $authProvider->setAuthServerId($serverId);
            $authProvider->setServerAddress($server->server_address);
            $authProvider->setPublicId($server->public_id);
            $authProvider->setPrivateKey($server->private_key);

            // TODO: check for exception / display error
            $response = $authProvider->checkResponse();
            $this->loginUser($response);

            return true;
        }

        return false;
    }

    protected function loginUser($userData)
    {
        if(!is_array($userData) || !isset($userData['user'])) return false;

        $user = \UserModel::findByUsername($userData['user']);

        if(!$user) {
            $user = new \UserModel();
            $user->username = $userData['username'];
        }

        // TODO: Update general user data
        $user->save();

        // Perform frontend login
        self::$allowLogin = true;
        $_POST['username'] = $user->username;
        $_POST['password'] = '#######';
        $_POST['REQUEST_TOKEN'] = REQUEST_TOKEN;

        $this->loginUserAction();
    }

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

    public function loginUserHookPassword($strUsername, $strPassword, $objUser)
    {
        if(self::$allowLogin) {
            return true;
        }

        return false;
    }
}
