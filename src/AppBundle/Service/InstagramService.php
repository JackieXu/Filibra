<?php


namespace AppBundle\Service;


/**
 * Class InstagramService
 *
 * @package AppBundle\Service
 */
class InstagramService
{
    const ACCESS_TOKEN_URI = 'https://api.instagram.com/oauth/access_token';

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
