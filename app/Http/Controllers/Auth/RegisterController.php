<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Address;
use App\Http\Requests\Auth\RegisterRequest;
use Illuminate\Http\Request;

class RegisterController extends Controller
{
    public function create(){
        return view('auth.register');
    }


    public function store(RegisterRequest $request){
        $requestData = $request->all();

        $requestData['user']['role'] = 'participant'; // DEFINE QUAL TIPO DE USUARIO É

        $user = User::create($requestData['user']); // CRIA O USUARIO NO BANCO
        
        $user->address()->create($requestData['address']);

        foreach ($requestData['phones'] as $phone){
            $user->phones()->create($phone);
        }  


    }
}
