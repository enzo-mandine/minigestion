<?php

namespace App\Models;

use CodeIgniter\Model;
use App\Entities\Produit;

class ProduitModel extends Model
{
    protected $table = 'produits';
    protected $primaryKey = 'id';
    protected $returnType    = Produit::class;
    protected $allowedFields = [
        'reference',
        'nom',
        'description',
        'prix_ht',
        'taux_tva',
        'stock',
        'actif',
    ];
    protected $useTimestamps = true;

    protected $validationRules = [
        'id'          => [
            'rules' => 'permit_empty|is_natural_no_zero'
        ],
        'reference' => [
            'label' => 'Référence',
            'rules' => 'required|regex_match[/^PRD-[0-9]{4}$/]|max_length[20]|is_unique[produits.reference,id,{id}]',
        ],
        'nom' => [
            'label' => 'Nom',
            'rules' => 'required|min_length[2]|max_length[150]',
        ],
        'prix_ht' => [
            'label' => 'Prix H.T.',
            'rules' => 'required|decimal|greater_than_equal_to[0]',
        ],
        'taux_tva' => [
            'label' => 'Taux T.V.A.',
            'rules' => 'required|in_list[0,5.5,10,20]',
        ],
        'stock' => [
            'label' => 'En Stock',
            'rules' => 'required|is_natural',
        ],
        'actif' => [
            'label' => 'Actif',
            'rules' => 'required|in_list[0,1]',
        ],
    ];

    protected $validationMessages = [
        'reference' => [
            'is_unique' => 'Cette référence est déjà utilisée.',
            'regex_match' => 'La référence doit respecter le format PRD-1234',
        ],
    ];

    // Callbacks : exécutés juste avant l'écriture en base
    protected $beforeInsert = ['normaliser'];
    protected $beforeUpdate = ['normaliser'];

    protected function normaliser(array $data): array
    {
        if (! isset($data['data'])) {
            return $data;
        }

        $d = $data['data'];

        // Retire les espaces en trop sur tous les champs texte
        foreach ($d as $champ => $valeur) {
            if (is_string($valeur)) {
                $d[$champ] = trim($valeur);
            }
        }

        if (isset($d['reference'])) {
            $d['reference'] = mb_strtoupper($d['reference']);
        }

        if (array_key_exists('description', $d) && $d['description'] === '') {
            $d['description'] = null;
        }

        $data['data'] = $d;

        return $data;
    }
}
