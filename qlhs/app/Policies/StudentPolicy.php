<?php

namespace App\Policies;

use App\Models\User;

class StudentPolicy
{
    /**
     * Create a new policy instance.
     */
    public function __construct()
    {
        
    }
    public function isTeacher(User $user){
        return $user->role === 'Giao vien chu nhiem';
    }
}