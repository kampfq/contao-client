<?php

/**
 * Contao Open Source CMS
 *
 * Copyright (c) 2005-2014 Leo Feyer
 *
 * @package   SuperLogin
 * @author    Hendrik Obermayer - Comolo GmbH
 * @license   -
 * @copyright 2016 Hendrik Obermayer
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
class AuthorizationController extends \System
{
    protected static $allowLogin = false;
    protected $serverId = null;

    /**
     * check for a new request to redirect to the auth server
     *
     * @return bool|void
     */
    public function listenForAuthRequest()
    {
        // run only in be mode
        if (TL_SCRIPT != 'contao/index.php' || TL_MODE != 'BE') return;
        
        // Initialize BackendUser before Database
        \BackendUser::getInstance();
        \Database::getInstance();  

        $serverId = intval(\Input::get('superlogin', 0));

        if ($serverId > 0) {

            $server = SuperLoginServerModel::findById($serverId);

            if ($server == false) {
                return false;
            }

            $authorization = new AuthorizationHelper();
            $authorization->redirectAction($server);

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

        $serverId = intval(\Input::get('superlogin', 0));
        $return = intval(\Input::get('return', 0));


        if ($serverId > 0 && $return == '1') {

            $server = SuperLoginServerModel::findById($serverId);

            if ($server == false) {
                return false;
            }

            $authorization = new AuthorizationHelper();
            $userDetails = $authorization->authorizationAction($server, \Input::get('code'));

            $this->loginUser((array) $userDetails);

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
        $user->name = $userData['fullname'];
        $user->email = $userData['email'];

        $user->language = 'de';
        $user->admin = true;

            // Todo
        //$user->language = (isset($userData['language'])) ? $userData['language'] : null;
        //$user->admin = (isset($userData['admin']) && $userData['admin'] == "1") ? true : false;

        // Save user
        $user->save();

        // Perform frontend login
        self::$allowLogin = true;
        $_POST['username'] = $user->username;
        $_POST['password'] = '#######';
        $_POST['REQUEST_TOKEN'] = REQUEST_TOKEN;

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
