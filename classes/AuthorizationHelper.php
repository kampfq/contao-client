<?php
/**
 * Created by PhpStorm.
 * User: hendrik
 * Date: 13.02.16
 * Time: 21:42
 */

namespace SuperLogin;
use \System;
use \Environment;

class AuthorizationHelper extends System
{
    /**
     * Redirect the user to the oauth server
     *
     */
    public function redirectAction(SuperLoginServerModel $server)
    {
        $provider = $this->createOAuth2Provider($server);
        $provider->authorize();
    }

    public function authorizationAction(SuperLoginServerModel $server, $code)
    {
        $provider = $this->createOAuth2Provider($server);

        try {
            
            $t = $provider->getAccessToken('authorization_Code', array('code' => $code));
            //$t = $provider->getAccessToken('authorization_code', array('code' => $code));

            // We got an access token, let's now get the user's details
            $userDetails = $provider->getUserDetails($t);

        } catch (Exception $e) {
            throw new AccessDeniedHttpException('an error occurred');
        }

        return $userDetails;
    }

    protected function createOAuth2Provider($server)
    {
        $base = substr(Environment::get('base'), 0, -1);
        $requestUri = Environment::get('requestUri');

        if (str_replace('&return=1', '', $requestUri) !== $requestUri) {
            $urlParts = explode('&return=1', $requestUri);
            $returnUrl = $base . $urlParts[0] . '&return=1';
        }
        else {
            $returnUrl = $base . $requestUri . '&return=1';
        }

        $provider = new OAuth2Provider(array(
            'authorizeUrl' => $server->url_authorize,
            'accessTokenUrl' => $server->url_access_token,
            'userDetailsUrl' => $server->url_resource_owner_details,
            'clientId'  =>  $server->public_id,
            'clientSecret'  =>  $server->secret,
            'redirectUri'   =>  $returnUrl
        ));

        return $provider;
    }
}