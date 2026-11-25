<?php

namespace App\Models;

use CodeIgniter\Model;

class ClientModel extends Model
{
    protected $table         = 'clients';
    protected $primaryKey    = 'id';
    protected $returnType    = 'array';
    protected $allowedFields = [
        'nom',
        'prenom',
        'email',
        'telephone',
        'entreprise',
        'ville'
    ];
    protected $useTimestamps = true;

    protected $validationRules = [
        'id' => [
            'rules' => 'permit_empty|is_natural_no_zero',
        ],
        'nom' => [
            'label' => 'Nom',
            'rules' => 'required|min_length[2]|max_length[100]',
        ],
        'prenom' => [
            'label' => 'Prénom',
            'rules' => 'permit_empty|max_length[100]',
        ],
        'email' => [
            'label' => 'Email',
            'rules' => 'required|valid_email|max_length[150]|is_unique[clients.email,id,{id}]',
        ],
        'telephone' => [
            'label' => 'Téléphone',
            'rules' => 'permit_empty|min_length[6]|max_length[30]|regex_match[/^[0-9 +().-]+$/]',
        ],
        'entreprise' => [
            'label' => 'Entreprise',
            'rules' => 'permit_empty|max_length[150]',
        ],
        'ville' => [
            'label' => 'Ville',
            'rules' => 'permit_empty|max_length[100]',
        ],
    ];

    protected $validationMessages = [
        'email' => [
            'is_unique' => 'Cet email est déjà utilisé par un autre client.',
        ],
        'telephone' => [
            'regex_match' => 'Le téléphone ne peut contenir que des chiffres, des espaces et + ( ) . -',
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

        // Mise en forme
        if (isset($d['nom'])) {
            $d['nom'] = mb_strtoupper($d['nom']);
        }
        if (isset($d['prenom'])) {
            $d['prenom'] = mb_convert_case($d['prenom'], MB_CASE_TITLE);
        }
        if (isset($d['email'])) {
            $d['email'] = mb_strtolower($d['email']);
        }

        // Un champ optionnel laissé vide devient NULL plutôt que ''
        foreach (['prenom', 'telephone', 'entreprise', 'ville'] as $champ) {
            if (array_key_exists($champ, $d) && $d[$champ] === '') {
                $d[$champ] = null;
            }
        }

        $data['data'] = $d;

        return $data;
    }
}
