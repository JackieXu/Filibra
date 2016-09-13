<?php


namespace AppBundle\Service;

use AppBundle\Entity\Challenge;
use AppBundle\Entity\User;
use AppBundle\Helper\TagFilter;


/**
 * Class InstagramService
 *
 * @package AppBundle\Service
 */
class InstagramService
{
    const ACCESS_TOKEN_URI = 'https://api.instagram.com/oauth/access_token';

    // API endpoints
    const ENDP_USERINFO = 'https://api.instagram.com/v1/users/%s';
    const ENDP_MEDIA = 'https://api.instagram.com/v1/users/%s/media/recent';

    /**
     * Instagram client id.
     *
     * @var string
     */
    protected $clientId;

    /**
     * Instagram client secret.
     *
     * @var string
     */
    protected $clientSecret;

    /**
     * InstagramService constructor.
     *
     * @param $clientId
     * @param $clientSecret
     */
    public function __construct($clientId, $clientSecret)
    {
        $this->clientId = $clientId;
        $this->clientSecret = $clientSecret;
    }

    /**
     * Gets Instagram login URL.
     *
     * @param string $redirectURL
     * @return string
     */
    public function getLoginURL(string $redirectURL): string
    {
        return sprintf(
            "https://api.instagram.com/oauth/authorize/?client_id=%s&redirect_uri=%s&response_type=code",
            $this->clientId,
            $redirectURL
        );
    }

    /**
     * Logs user in via authorization code.
     *
     * TODO: Implement proper error/exception handling.
     *
     * @param string $code
     * @param string $redirectURI
     * @return bool|array
     */
    public function login($code, $redirectURI)
    {
        $data = $this->post(self::ACCESS_TOKEN_URI, [
            'client_id' => $this->clientId,
            'client_secret' => $this->clientSecret,
            'code' => $code,
            'grant_type' => 'authorization_code',
            'redirect_uri' => $redirectURI
        ]);

        if ($data) {
            return $data;
        }

        return false;
    }

    public function getUserMediaForChallenge(User $user, Challenge $challenge)
    {
        $tagFilter = new TagFilter($challenge);

        // array containing all media for this challenge
        $userMedia = [];

        // retrieve media in pages, instagram returns 20 items by default
        $nextMaxId = null;

        do {
            // retrieve data from Instagram api
            $recentMediaUrl = $this->getRecentMediaURL($user);
            $data = $this->get($recentMediaUrl, ['access_token' => $user->getInstagramAccessToken(),
                'count' => 20, 'max_id' => $nextMaxId]);

            // reset nextMaxId so that any errors will not cause an infinite loop
            $nextMaxId = null;
            if ($data !== false) {
                if ($data['meta']['code'] === 200) {
                    // filter every image by its hashtags for this challenge
                    $filtered = array_filter($data['data'], array($tagFilter, 'instagramFilter'));

                    $userMedia = array_merge($userMedia, $filtered);

                    // null if next_url is not set, end loop here.
                    // TODO: stop looking for images posted before challenge start date.
                    $nextMaxId = $data['pagination']['next_max_id'] ?? null;
                }
            }
        } while ($nextMaxId !== null);

        return $userMedia;
    }

    private function getRecentMediaURL(User $user, $page = 1): string
    {
        return sprintf(self::ENDP_MEDIA, $user->getInstagramId());
    }

    /**
     * Sends GET request.
     *
     * @param string $URL
     * @param array $parameters
     * @return bool|string
     */
    protected function get($URL, array $parameters)
    {
        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, $URL . "?" . http_build_query($parameters));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

        $dataString = curl_exec($ch);

        curl_close($ch);

        $data = json_decode($dataString, true);

        if (json_last_error() !== JSON_ERROR_NONE) {
            return false;
        }

        return $data;
    }

    /**
     * Sends POST request.
     *
     * @param string $URL
     * @param array $parameters
     * @return bool|string
     */
    protected function post($URL, array $parameters)
    {
        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, $URL);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($parameters));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

        $dataString = curl_exec($ch);

        curl_close($ch);

        $data = json_decode($dataString, true);

        if (json_last_error() !== JSON_ERROR_NONE) {
            return false;
        }

        return $data;
    }
}
