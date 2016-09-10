<?php


namespace AppBundle\Service;
use Facebook\Authentication\AccessToken;
use Facebook\Exceptions\FacebookResponseException;
use Facebook\Exceptions\FacebookSDKException;
use Facebook\Facebook;

/**
 * Class FacebookService
 *
 * @package AppBundle\Service
 */
class FacebookService
{
    protected $client;

    /**
     * FacebookService constructor.
     *
     * @param string $appId
     * @param string $appSecret
     * @param string $graphVersion
     */
    public function __construct(string $appId, string $appSecret, string $graphVersion = 'v2.7')
    {
        $this->client = new Facebook([
            'app_id' => $appId,
            'app_secret' => $appSecret,
            'default_graph_version' => $graphVersion
        ]);
    }

    /**
     * Gets Facebook login URL.
     *
     * @param string $redirectURL
     * @return string
     */
    public function getLoginURL(string $redirectURL): string
    {
        $helper = $this->client->getRedirectLoginHelper();
        $permissions = [
            'email',
            'user_about_me',
            'user_photos',
            'user_posts',
            'user_videos'
        ];

        return $helper->getLoginUrl($redirectURL, $permissions);
    }

    /**
     * Get Facebook access token via authorization code.
     *
     * @return bool|AccessToken
     */
    public function getAccessToken()
    {
        $helper = $this->client->getRedirectLoginHelper();

        try {
            $accessToken = $helper->getAccessToken();
        } catch (FacebookResponseException $e) {
            error_log(sprintf('Graph returned an exception: %s', $e->getMessage()));

            return false;
        } catch (FacebookSDKException $e) {
            error_log(sprintf('Facebook SDK returned an exception: %s', $e->getMessage()));

            return false;
        }

        if (!$accessToken) {
            return false;
        }

        return $accessToken;
    }

    /**
     * Gets Facebook user graph node via access token.
     *
     * @param AccessToken $accessToken
     * @return bool|\Facebook\GraphNodes\GraphUser
     */
    public function getUserByAccessToken(AccessToken $accessToken)
    {
        $OAuth2Client = $this->client->getOAuth2Client();

        if (!$accessToken->isLongLived()) {
            try {
                $accessToken = $OAuth2Client->getLongLivedAccessToken($accessToken);
            } catch (FacebookSDKException $e) {
                error_log(sprintf('Facebook SDK error while retrieving long-lived access token: %s', $e->getMessage()));

                return false;
            }
        }

        try {
            $response = $this->client->get('/me?fields=id,name,email,picture', $accessToken);
        } catch (FacebookResponseException $e) {
            error_log(sprintf('Graph returned an exception: %s', $e->getMessage()));

            return false;
        } catch (FacebookSDKException $e) {
            error_log(sprintf('Facebook SDK returned an exception: %s', $e->getMessage()));

            return false;
        }

        return $response->getGraphUser();
    }
}
