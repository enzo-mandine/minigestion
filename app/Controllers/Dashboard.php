<?php


namespace App\Controllers;

use App\Models\ClientModel;
use App\Models\ProduitModel;

class Dashboard extends BaseController
{
    public function index(): string
    {
        $data = [
            'title' => 'Tableau de bord',
            'stats' => [
                'clients'  => model(ClientModel::class)->countAllResults(),
                'produits' => model(ProduitModel::class)->countAllResults(),
                'factures' => 0,
            ],
            'ruptures' => model(ProduitModel::class)->where('stock', 0)->countAllResults(),
        ];
        return view('dashboard/index', $data);
    }
}
