<?php

namespace App\Controllers;

use App\Models\ProductModel;
use CodeIgniter\Exceptions\PageNotFoundException;

class Products extends BaseController
{
    private ProductModel $products;
    private const FIELDS = ['reference', 'nom', 'description', 'prix_ht', 'taux_tva', 'stock', 'actif'];

    private function findOrFail(int $id): array
    {
        return $this->products->find($id)
            ?? throw PageNotFoundException::forPageNotFound("Produit n°#$id introuvable");
    }

    public function __construct()
    {
        $this->products = model(ProductModel::class);
    }

    // GET /clients
    public function index(): string
    {
        $q = trim((string) $this->request->getGet('q'));

        if ($q !== '') {
            $this->products->groupStart()
                ->like('nom', $q)
                ->orLike('reference', $q)
                ->orLike('actif', $q)
                ->groupEnd();
        }

        return view('products/index', [
            'title'   => 'Produits',
            'products' => $this->products->orderBy('nom')->paginate(10),
            'pager'   => $this->products->pager,
            'q'       => $q,
        ]);
    }

    public function new(): string
    {
        return view('products/form', [
            'title' => 'Nouveau produit',
            'product' => null
        ]);
    }

    public function create()
    {
        $data = $this->request->getPost(self::FIELDS);

        if (! $this->products->insert($data)) {
            return redirect()->back()->withInput()->with('errors', $this->products->errors());
        }

        return redirect()->to('products')->with('success', 'Produit créé avec succès.');
    }

    public function edit(int $id): string
    {
        return view('products/form', [
            'title'  => 'Modifier le produit',
            'product' => $this->findOrFail($id),
        ]);
    }

    public function update(int $id)
    {
        $this->findOrFail($id);

        $data       = $this->request->getPost(self::FIELDS);
        $data['id'] = $id;

        if (! $this->products->save($data)) {
            return redirect()->back()->withInput()->with('errors', $this->products->errors());
        }

        return redirect()->to('products')->with('success', 'Produit modifié avec succès.');
    }

    public function delete(int $id)
    {
        $this->findOrFail($id);
        $this->products->delete($id);

        return redirect()->to('products')->with('success', 'Produit supprimé.');
    }

    public function show(int $id)
    {
        return view('products/card', [
            'title' => 'Fiche produit',
            'product' => $this->findOrFail($id),
        ]);
    }
}
