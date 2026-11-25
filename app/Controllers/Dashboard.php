<?php


namespace App\Controllers;

use App\Models\ClientModel;

class Dashboard extends BaseController
{
    public function index(): string
    {
        $data = [
            'title' => 'Tableau de bord',
            'stats' => [
                'clients'  => model(ClientModel::class)->countAllResults(),
                'produits' => 0,
                'factures' => 0,
            ],
        ];
        return view('dashboard/index', $data);
    }
}
