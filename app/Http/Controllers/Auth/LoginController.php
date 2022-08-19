<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Support\Facades\Auth;
use App\Services\UserService;

class LoginController extends Controller
{
    public function create()
    {
        return view('auth.login');
    }

    public function store(LoginRequest $request)
    {
        $credentials = [
            'email' => $request->email,
            'password' => $request->password
        ];



        // ESSA PARTE DIRECIONA O USUARIO PARA A PAGINA DO TIPO DE USUARIO QUE ELE É, APÓS O LOGIN
        if (auth::attempt($credentials)) {
            $userRole = auth()->user()->role;
            return redirect(UserService::getDashboardRouteBasedOnUserRole(($userRole)));

            
        }

        return redirect()
            ->route('auth.login.create')
            ->with('warning', 'Autenticação falhou!')
            ->withInput();
    }

    public function destroy(){
        Auth::logout();
        return redirect()->route('auth.login.create');
    }
}
