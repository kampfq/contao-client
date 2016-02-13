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
    public function redirectAction($server)
    {
        $provider = $this->createOAuth2Provider($server);
        $provider->authorize();
    }

    public function authorizationAction($serverId)
    {
        $server = $this->get('superlogin.server_manager')->find($serverId);
        $request = $this->get('request');
        $state = $request->query->get('state');
        $state_session = $this->get('session')->get('oauth2state');

        // Server not found
        if (!$server) {
            throw new AccessDeniedHttpException('Unknown server');
        }

        // Init provider
        $provider = $this->get('superlogin.server_manager')->createOAuth2Provider($server);

        // Validate state
        if (empty($state) || ($state !== $state_session)) {
            $this->get('session')->remove('oauth2state');
            throw new AccessDeniedHttpException('Invalid state');
        }

        try {

            // Get Access token
            $accessToken = $provider->getAccessToken('authorization_code', [
                'code' => $request->query->get('code')
            ]);

            // Get Resource Owner
            $resourceOwner = $provider->getResourceOwner($accessToken);
            $userDetails = $resourceOwner->toArray()['user'];

            // Simulate Contao login
            $contaoUser = $this->get('superlogin.remote_user')->create($userDetails);
            $this->get('superlogin.remote_user')->createOrUpdate($contaoUser);
            $this->get('superlogin.remote_user')->loginAs($contaoUser);

            return $this->redirectToRoute('contao_backend');

        } catch (IdentityProviderException $e) {
            // Failed to get the access token or user details.
            throw new AccessDeniedHttpException('an error occured');
        }
    }

    protected function createOAuth2Provider($server)
    {
        $returnUrl = Environment::get('base') . Environment::get('requestUri') . '&return=1';

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