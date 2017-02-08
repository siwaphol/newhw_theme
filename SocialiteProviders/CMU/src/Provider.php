<?php

namespace SocialiteProviders\CMU;

use Laravel\Socialite\Two\ProviderInterface;
use SocialiteProviders\Manager\OAuth2\AbstractProvider;
use SocialiteProviders\Manager\OAuth2\User;

class Provider extends AbstractProvider implements ProviderInterface
{
    /**
     * Unique Provider Identifier.
     */
    const IDENTIFIER = 'CMU';

    /**
     * {@inheritdoc}
     */
    protected $scopes = [''];

    /**
     * {@inheritdoc}
     */
    protected function getAuthUrl($state)
    {
        return $this->buildAuthUrlFromBase('https://accountapi.cmu.ac.th/auth/Authorize.aspx', $state);
    }

    /**
     * {@inheritdoc}
     */
    protected function getTokenUrl()
    {
        return 'https://accountapi.cmu.ac.th/auth/GetToken.aspx';
    }

    /**
     * {@inheritdoc}
     */
    protected function getUserByToken($token)
    {
        $endpoint = 'https://accountapi.cmu.ac.th/auth/UserInfo.aspx';
        $query = [
            'oauth_token' => $token,
        ];

        $response = $this->getHttpClient()->get(
            $endpoint, [
            'query' => $query,
            'headers' => [
                'Accept' => 'application/json',
            ],
        ]);
        return json_decode($response->getBody()->getContents(), true)['data'];
    }

    /**
     * {@inheritdoc}
     */
    protected function mapUserToObject(array $user)
    {
        return (new User())->setRaw($user)->map([
            'username' => $user['itaccount_name'],
            'id'       => ($user['student_id']?$user['student_id']:''),
            'firstname_en' => $user['first_name']['en_US'],
            'lastname_en' => $user['last_name']['en_US'],
            'firstname_th' => $user['first_name']['th_TH'],
            'lastname_th' => $user['last_name']['th_TH'],
            'organization'    => $user['organization'],
            'itaccount_type'   => $user['itaccount_type'],
        ]);
    }

    /**
     * {@inheritdoc}
     */
    protected function getTokenFields($code)
    {
        return array_merge(parent::getTokenFields($code), [
            'grant_type' => 'authorization_code'
        ]);
    }
}
