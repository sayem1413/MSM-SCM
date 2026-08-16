<?php

namespace App\Services;

use App\Exceptions\JwtException;
use Illuminate\Support\Carbon;

class JwtService
{
    protected $request;

    protected $token;

    protected $payload;

    public function __construct()
    {
        $this->request = request();
    }

    public function getTokenForRequest()
    {
        if ($this->token !== null) {
            return $this->token;
        }

        $token = $this->request->query('token');

        if (empty($token)) {
            $token = $this->request->input('token');
        }

        if (empty($token)) {
            $token = $this->request->bearerToken();
        }

        return $this->token = $token;
    }

    /**
     * Get the token for the current request.
     *
     * @return string
     */
    public function hasToken()
    {
        return is_null($this->getTokenForRequest()) ? false : true;
    }

    protected function encode($data)
    {
        return $this->base64url_encode(json_encode($data));
    }

    protected function decode($data)
    {
        return json_decode($this->base64url_decode($data));
    }

    protected function base64url_encode($data) {
        return rtrim(strtr(base64_encode($data), '+/', '-_'), '=');
    }

    protected function base64url_decode($data) {
        return base64_decode(str_pad(strtr($data, '-_', '+/'), strlen($data) % 4, '=', STR_PAD_RIGHT));
    }

    protected function sign($header, $payload)
    {
        return $this->base64url_encode(hash_hmac('SHA256', "$header.$payload", config('jwt.key'), true));
    }

    public function verify($token)
    {
        $segments = explode('.', $token);

        if (count($segments) !== 3) return false;

        $expected = $this->base64url_encode(hash_hmac('sha256', "$segments[0].$segments[1]", config('jwt.key'), true));

        return hash_equals($expected, $segments[2]);
    }

    public function isExpired($token)
    {
        $payload = $this->getPayload($token);

        if (is_null($payload->exp)) {
            return false;
        }

        return Carbon::createFromTimestamp($payload->exp)->isPast();
    }

    public function checkToken($token)
    {
        if (! $token) {
            throw new JwtException("We could not find the access token.", 1);
        }

        if (! $this->verify($token)) {
            throw new JwtException("The access token is invalid.", 1);
        }

        /*if ($this->isExpired($token)) {
            throw new JwtException("The access token expired.", 1);
        }*/
    }

    public function getPayload($token)
    {
        $payload = explode('.', $token);

        if (count($payload) !== 3) return null;

        $payloadData = $this->decode($payload[1]);

        return $payloadData;
    }

    public function getTokeInfo()
    {
        $token = $this->getTokenForRequest();
        $payload = $this->getPayload($token);
        return isset($payload->sub) ? $payload->sub : null;
    }

}
