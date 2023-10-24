<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Log;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'company',
        'linked_in',
        'last_provider'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function userEmails()
    {
        return $this->hasMany(UserEmail::class);
    }

    public function getProviders()
    {
        $providers = config('providers_list');
        Log::info($providers);
        $lastProvider = $this->last_provider;
        if (!$lastProvider) {
            return $providers;
        }
        $key = array_search($lastProvider, $providers);
        if ($key !== false) {
            return array_slice($providers, $key + 1);
        } else {
            return $providers;
        }
    }
}
