<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserAdminRelation extends Model
{
    protected $table = 'user_admin_relations';
    protected $fillable = [
        'user_id', 'role'
    ];
}
