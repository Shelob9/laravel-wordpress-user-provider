<?php


namespace App\Http\Clients;


use Illuminate\Support\Facades\Http;

class WordPressApiClient
{

    public string $apiUrl;
    protected  $token;
    public function __construct(string $apiUrl,?string $token = null)
    {
        $this->apiUrl = $apiUrl;
        if( $token){
            $this->token = $token;
        }

    }

    public function setToken(string $token ){
         $this->token = $token;
        return $this;
    }

    public function hasToken():bool
    {
        return  isset($this->token) && is_string($this->token);
    }

    public function get(string $endpoint, array $query = [])
    {
        $url = $this->makeRequestUrl($endpoint);
        if( $this->hasToken()  ){
            return Http::withToken($this->token)->get(
                $url,
                $query
            );
        }
        return Http::get(
            $url,
            $query
        );

    }

    public function post(string $endpoint, array $body){
        $url = $this->makeRequestUrl($endpoint);
        if( $this->hasToken()  ){
            return Http::withToken($this->token)->post(
                $url,
                $body
            );
        }
        return Http::post(
            $url,
            $body
        );
    }

    public function getToken(string $username, string $password )
    {
        $response =  $this->post('/jwt-auth/v1/token', [
            'username' => $username,
            'password' => $password
        ]);
        dd($response);
    }

    public function validateToken(string  $token, int  $userId)
    {
        $response = Http::withToken($token)
            ->post(
                $this->makeRequestUrl('/jwt-auth/v1/token/'. $userId)
            );
        dd($response);

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


}
