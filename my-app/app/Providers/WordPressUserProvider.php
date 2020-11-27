<?php

namespace App\Providers;

use App\Http\Clients\WordPressApiClient;
use App\Models\User;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Contracts\Auth\UserProvider;
use Illuminate\Support\ServiceProvider;

class WordPressUserProvider  implements  UserProvider
{



    protected WordPressApiClient $wordpressClient;


    protected array $userCache;


    public function __construct()
    {
        $this->wordpressClient = new WordPressApiClient(
            'https://calderaforms.com/wp-json'
        );

    }

    public function getModel()
    {
        return User::class;
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    public function retrieveById($identifier)
    {
        if( array_key_exists($identifier,$this->userCache)){
            return $this->userCache[$identifier];
        }

        //must login
    }

    public function retrieveByToken($identifier, $token)
    {
        $r = $this->wordpressClient->validateToken($token,$identifier);

    }

    public function updateRememberToken(Authenticatable $user, $token)
    {
        // TODO: Implement updateRememberToken() method.
    }

    public function retrieveByCredentials(array $credentials)
    {
        dd(1,$credentials);
        $r = $this->wordpressClient->getToken($credentials['username'], $credentials['password']);
    }

    public function validateCredentials(Authenticatable $user, array $credentials)
    {        dd(11,$credentials);

        $r = $this->wordpressClient->getToken($credentials['username'], $credentials['password']);
    }

}
