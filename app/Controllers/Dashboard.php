<?php


namespace App\Controllers;

use App\Models\ClientModel;
use App\Models\ProductModel;

class Dashboard extends BaseController
{
    public function index(): string
    {
        $data = [
            'title' => 'Tableau de bord',
            'stats' => [
                'clients'  => model(ClientModel::class)->countAllResults(),
                'produits' => model(ProductModel::class)->countAllResults(),
                'factures' => 0,
            ],
        ];
        return view('dashboard/index', $data);
    }
}
