<?php


namespace App\Http\Clients;


use App\DTO\UserResponse;
use Illuminate\Support\Facades\Http;

class WordPressApiClient
{

    public string $apiUrl;
    protected $token;

    protected array $options = [
        'verify' => false
    ];

    public function __construct(string $apiUrl, ?string $token = null)
    {
        $this->apiUrl = $apiUrl;
        if ($token) {
            $this->token = $token;
        }

    }

    public function setToken(string $token)
    {
        $this->token = $token;
        return $this;
    }

    public function hasToken(): bool
    {
        return isset($this->token) && is_string($this->token);
    }

    public function get(string $endpoint, array $query = [])
    {
        $url = $this->makeRequestUrl($endpoint);
        $response = $this->createRequest()
            ->get(
                $url,
                $query
            );
        return $this->userOrAbort($response);


    }

    public function post(string $endpoint, array $body)
    {
        $url = $this->makeRequestUrl($endpoint);
        $response = $this->createRequest()
            ->post(
                $url,
                $body
            );

        return $this->userOrAbort($response);
    }


        public function getToken(string $username, string $password)
    {
        return $this->post('/jwt-auth/v1/token', [
            'username' => $username,
            'password' => $password
        ]);

    }

    public function validateToken(string $token, int $userId) :bool
    {
        $response = Http::withToken($token)
            ->withOptions($this->options)
            ->post(
                $this->makeRequestUrl('/jwt-auth/v1/token/' . $userId)
            );
       return $response->successful();

    }


    /**
     * @param string $endpoint
     * @return string
     */
    protected function makeRequestUrl(string $endpoint): string
    {
        $url = $this->apiUrl . $endpoint;
        return $url;
    }

    /**
     * @return \Illuminate\Http\Client\PendingRequest
     */
    protected function createRequest(): \Illuminate\Http\Client\PendingRequest
    {
        $request = Http::withOptions($this->options);
        if ($this->hasToken()) {
            $request = $request
                ->withToken($this->token);
        }
        return $request;
    }

    /**
     * @param \Illuminate\Http\Client\Response $response
     * @return mixed
     */
    protected function userOrAbort(\Illuminate\Http\Client\Response $response)
    {
        if (!$response->successful()) {
            abort($response->status());
        }
        return json_decode($response->body(), true);
    }


}
