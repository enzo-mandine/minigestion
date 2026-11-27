<?php

namespace App\Controllers;

use App\Models\ProduitModel;
use CodeIgniter\Exceptions\PageNotFoundException;

class Produits extends BaseController
{
    private ProduitModel $products;
    private const FIELDS = ['reference', 'nom', 'description', 'prix_ht', 'taux_tva', 'stock', 'actif'];

    private function findOrFail(int $id): array
    {
        return $this->products->find($id)
            ?? throw PageNotFoundException::forPageNotFound("Produit introuvable");
    }

    private function donneesFormulaire(): array
    {
        $data = $this->request->getPost(self::FIELDS);

        $data['reference'] = mb_strtoupper(trim((string) $data['reference']));
        $data['prix_ht'] = str_replace(',', '.', (string) $data['prix_ht']);
        $data['actif'] = $data['actif'] ?? '0';

        return $data;
    }

    public function __construct()
    {
        $this->products = model(ProduitModel::class);
    }

    // GET /produits
    public function index(): string
    {
        $q = trim((string) $this->request->getGet('q'));
        $actifs = $this->request->getGet('actifs') === '1';


        if ($q !== '') {
            $this->products->groupStart()
                ->like('nom', $q)
                ->orLike('reference', $q)
                ->groupEnd();
        }

        if ($actifs) {
            $this->products->where('actif', 1);
        }

        helper('number');
        helper('text');
        
        return view('produits/index', [
            'title'   => 'Produits',
            'products' => $this->products->orderBy('nom')->paginate(10),
            'actifs' => $actifs,
            'pager'   => $this->products->pager,
            'q'       => $q,
        ]);
    }

    public function new(): string
    {
        return view('produits/form', [
            'title' => 'Nouveau produit',
            'product' => null
        ]);
    }

    public function create()
    {
        $data = $this->donneesFormulaire();

        if (! $this->products->insert($data)) {
            return redirect()->back()->withInput()->with('errors', $this->products->errors());
        }

        return redirect()->to('produits')->with('success', 'Produit créé avec succès.');
    }

    public function edit(int $id): string
    {
        return view('produits/form', [
            'title'  => 'Modifier le produit',
            'product' => $this->findOrFail($id),
        ]);
    }

    public function update(int $id)
    {
        $this->findOrFail($id);

        $data = $this->donneesFormulaire();
        $data['id'] = $id;

        if (! $this->products->save($data)) {
            return redirect()->back()->withInput()->with('errors', $this->products->errors());
        }

        return redirect()->to('produits')->with('success', 'Produit modifié avec succès.');
    }

    public function delete(int $id)
    {
        $this->findOrFail($id);
        $this->products->delete($id);

        return redirect()->to('produits')->with('success', 'Produit supprimé.');
    }

    public function show(int $id)
    {
        return view('produits/card', [
            'title' => 'Fiche produit',
            'product' => $this->findOrFail($id),
        ]);
    }
}
