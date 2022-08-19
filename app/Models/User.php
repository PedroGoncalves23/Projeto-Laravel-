<?php

namespace App\Models;

use Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use HasFactory;

    protected $table = 'users';

    protected $fillable = [
        'name',
        'email',
        'cpf',
        'password',
        'role'
    ];

    protected $hidden = [
        'password'
    ];

    //RELACIONAMENTOS
    public function address(){
        return $this->hasOne(Address::class); // cria relacionamento com tabela Address
    }

    public function phones(){
        return $this->hasMany(Phone::class);
    }

    public function events()
    {
        return $this->belongsToMany(Event::class);
    }

    //MUTATORS
        public function setPasswordAttribute($value){
            $this->attributes['password'] = bcrypt($value); // CRIA HASH DA SENHA (SE TORNA MAIS SEGURO)
        }
}
