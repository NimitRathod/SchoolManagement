<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Permission\Traits\HasRoles;

class Teachers extends User
{
    use HasFactory, HasRoles;
    
    protected $guard_name = 'web';
    protected $table = 'users';
}
