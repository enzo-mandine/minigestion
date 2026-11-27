<?php

namespace App\Entities;

use CodeIgniter\Entity\Entity;

class Produit extends Entity
{
    protected $dates   = ['created_at', 'updated_at', 'deleted_at'];
    protected $casts   = [
        'id' => 'integer',
        'prix_ht' => 'float',
        'taux_tva' => 'float',
        'stock' => 'integer',
        'actif' => 'boolean',
    ];

    public function getPrixTtc(): float
    {
        return round($this->prix_ht * (1 + $this->taux_tva / 100), 2);
    }

    public function getMontantTva(): float
    {
        return round($this->prix_ttc - $this->prix_ht, 2);
    }

    public function etatStock(): string
    {
        return match (true) {
            $this->stock === 0 => 'rupture',
            $this->stock < 5 => 'faible',
            default => 'ok',
        };
    }
}
