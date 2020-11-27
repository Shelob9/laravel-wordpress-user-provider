<?php
namespace  App\DTO;

class UserResponse extends \Spatie\DataTransferObject\DataTransferObject
{
    public int $ID;

    public string $token;

    public string $user_email;

    public function toModel() : \App\Models\User
    {
        $user = new \App\Models\User();
        $user->forceFill([
            'id' => $this->ID,
            'name' => $this->user_email,
            'email' => $this->user_email,
            'token' => $this->token
        ]);
        return  $user;
    }
}
