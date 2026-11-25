<?php

namespace App\Controllers;

use App\Models\UserModel;

class Auth extends BaseController
{
    public function login()
    {
        if (session()->has('user')) {
            return redirect()->to('/');
        }

        return view('auth/login', ['title' => 'Connexion']);
    }

    public function attemptLogin()
    {
        $email = mb_strtolower(trim((string) $this->request->getPost('email')));
        // 1. Validation du format
        $rules = [
            'email' => ['label' => 'Email', 'rules' => 'required|valid_email'],
            'password' => ['label' => 'Mot de passe', 'rules' => 'required'],
        ];


        if (! $this->validate($rules)) {
            return redirect()->to('login')
                ->with('errors', $this->validator->getErrors())
                ->with('login_email', $email);
        }

        // 2. Limite par compte visé (la limite par IP est gérée par le filtre)
        $throttler = service('throttler');

        if ($throttler->check('login_email_' . md5($email), 5, MINUTE) === false) {
            $attente = max(1, $throttler->getTokenTime());

            return redirect()->to('login')
                ->with('error', "Trop de tentatives pour ce compte. Réessayez dans {$attente} seconde(s).")
                ->with('login_email', $email);
        }

        // 3. Vérification des identifiants
        $user = model(UserModel::class)->findByEmail($email);

        if ($user === null || !password_verify((string) $this->request->getPost('password'), $user['password_hash'])) {
            return redirect()->to('login')
                ->with('error', 'Email ou mot de passe incorrect.')
                ->with('login_email', $email);
        }

        session()->regenerate();

        session()->set('user', [
            'id' => $user['id'],
            'nom' => $user['nom'],
            'email' => $user['email'],
        ]);

        $url = session('redirect_url') ?? site_url('/');
        session()->remove('redirect_url');
        
        return redirect()->to($url)->with('success', 'Bienvenue ' . $user['nom'] . '!');
    }

    public function logout()
    {
        session()->remove('user');
        session()->regenerate(true);

        return redirect()->to('login')->with('info', 'Vous êtes déconnecté.');
    }
}
