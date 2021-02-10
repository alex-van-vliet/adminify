<?php


namespace AlexVanVliet\Adminify\Tests;


use AlexVanVliet\Adminify\Tests\Database\Factories\UserFactory;
use AlexVanVliet\Migratify\Fields\Field;
use AlexVanVliet\Migratify\Model;
use AlexVanVliet\Migratify\ModelTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

#[Model([
    'name' => [Field::STRING],
    'email' => [Field::STRING, ['unique']],
    'email_verified_at' => [Field::TIMESTAMP, ['nullable']],
    'password' => [Field::STRING, []],
    'remember_token' => [Field::STRING, ['length' => 100, 'nullable']],
    'admin' => [Field::BOOLEAN, ['default' => false]],
])]
class User extends Authenticatable
{
    use HasFactory, Notifiable, ModelTrait;

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];


    /**
     * Create a new factory instance for the model.
     *
     * @return UserFactory
     */
    protected static function newFactory()
    {
        return UserFactory::new();
    }
}
