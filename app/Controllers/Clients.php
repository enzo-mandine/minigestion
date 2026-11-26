<?php

namespace App\Controllers;

use App\Models\ClientModel;
use CodeIgniter\Exceptions\PageNotFoundException;

class Clients extends BaseController
{
    private ClientModel $clients;

    private const FIELDS = ['nom', 'prenom', 'email', 'telephone', 'entreprise', 'ville'];


    private function findOrFail(int $id): array
    {
        return $this->clients->find($id)
            ?? throw PageNotFoundException::forPageNotFound("Client #$id introuvable");
    }

    public function __construct()
    {
        $this->clients = model(ClientModel::class);
    }

    // GET /clients
    public function index(): string
    {
        $q = trim((string) $this->request->getGet('q'));

        if ($q !== '') {
            $this->clients->groupStart()
                ->like('nom', $q)
                ->orLike('prenom', $q)
                ->orLike('email', $q)
                ->orLike('entreprise', $q)
                ->groupEnd();
        }

        return view('clients/index', [
            'title'   => 'Clients',
            'clients' => $this->clients->orderBy('nom')->paginate(10),
            'pager'   => $this->clients->pager,
            'q'       => $q,
        ]);
    }

    // GET /clients/new
    public function new(): string
    {
        return view('clients/form', [
            'title' => 'Nouveau client', 'client' => null]);
    }

    // POST /clients
    public function create()
    {
        $data = $this->request->getPost(self::FIELDS);

        if (! $this->clients->insert($data)) {
            return redirect()->back()->withInput()->with('errors', $this->clients->errors());
        }

        return redirect()->to('clients')->with('success', 'Client créé avec succès.');
    }

    // GET /clients/5/edit
    public function edit(int $id): string
    {
        return view('clients/form', [
            'title'  => 'Modifier le client',
            'client' => $this->findOrFail($id),
        ]);
    }

    // POST /clients/5/update
    public function update(int $id)
    {
        $this->findOrFail($id);

        $data       = $this->request->getPost(self::FIELDS);
        $data['id'] = $id;

        if (! $this->clients->save($data)) {
            return redirect()->back()->withInput()->with('errors', $this->clients->errors());
        }

        return redirect()->to('clients')->with('success', 'Client modifié avec succès.');
    }

    // POST /clients/5/delete
    public function delete(int $id)
    {
        $this->findOrFail($id);
        $this->clients->delete($id);

        return redirect()->to('clients')->with('success', 'Client supprimé.');
    }

    public function show(int $id)
    {
        return view('clients/card', [
            'title' => 'Fiche client',
            'client' => $this->findOrFail($id),
        ]);
    }
}
