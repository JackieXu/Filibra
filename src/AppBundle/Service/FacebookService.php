<?php


namespace AppBundle\Service;
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
    public function __construct(string $appId, string $appSecret, string $graphVersion = '2.7')
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
}
