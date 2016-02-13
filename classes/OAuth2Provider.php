<?php
/**
 * Created by PhpStorm.
 * User: hendrik
 * Date: 13.02.16
 * Time: 21:51
 */

namespace SuperLogin;
use League\OAuth2\Client\Provider\IdentityProvider;
use League\OAuth2\Client\Provider\User;


class OAuth2Provider extends IdentityProvider
{
    protected $superlogin_url_authorize = '';
    protected $superlogin_url_access_token = '';
    protected $superlogin_url_user_details = '';

    public function __construct($options = array())
    {
        if (isset($options['authorizeUrl'])) {
            $this->superlogin_url_authorize = $options['authorizeUrl'];
        }

        if (isset($options['accessTokenUrl'])) {
            $this->superlogin_url_access_token = $options['accessTokenUrl'];
        }

        if (isset($options['userDetailsUrl'])) {
            $this->superlogin_url_user_details = $options['userDetailsUrl'];
        }

        return parent::__construct($options);
    }

    public function urlAuthorize()
    {
        return $this->superlogin_url_authorize;
    }

    public function urlAccessToken()
    {
        return $this->superlogin_url_access_token;
    }

    public function urlUserDetails(\League\OAuth2\Client\Token\AccessToken $token)
    {
        return $this->superlogin_url_user_details.'?access_token='.$token;
    }

    public function userDetails($response, \League\OAuth2\Client\Token\AccessToken $token)
    {
        return $response->user;
    }

    public function userUid($response, \League\OAuth2\Client\Token\AccessToken $token)
    {
        return $response->user->user_id;
    }

    public function userEmail($response, \League\OAuth2\Client\Token\AccessToken $token)
    {
        return isset($response->user->email) && $response->user->email ? $response->user->email : null;
    }

    public function userScreenName($response, \League\OAuth2\Client\Token\AccessToken $token)
    {
        return $response->user->user_id;
    }
}