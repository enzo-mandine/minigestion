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
                'ruptures' => model(ProduitModel::class)->where('stock', 0)->countAllResults(),
                'factures' => 0,
            ],
        ];
        return view('dashboard/index', $data);
    }
}
