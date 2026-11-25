<?php

namespace App\Controllers;

class About extends BaseController
{
    public function index(): string
    {
        return view('about/index', [
            'title' => 'À propos',
            'content' => 'Bienvenue sur la page À propos de notre application.',
        ]);
    }
}
