<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TokenManagement extends Model
{
    protected $table = 'token_management';
    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'created_by', 'access_token', 'expired_at', 'active'
    ];

    public function admin()
    {
        return $this->belongsTo(Admin::class);
    }
}
