<?php
namespace App\Services;

use Illuminate\Support\Facades\Auth;

class AuthService 
{
    
    public function getUserAuthenticated()
    {
        $user = Auth::user();
        if (!$user) {
            return null;
        }
        return $user;
    }


}