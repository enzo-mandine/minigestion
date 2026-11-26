<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>

<?php
$labels = [
    'reference'     => 'Référence',
    'nom'  => 'Nom',
    'description'  => 'Description',
    'prix_ht'  => 'Prix H.T.',
    'taux_tva'  => 'Taux T.V.A.',
    'stock'  => 'Stock',
    'actif'  => 'Actif',
    'created_at' => 'Date de création',
    'updated_at' => 'Dernière modification',
];
?>

<div class="container my-4">
    <div class="card shadow-sm mx-auto w-75">
        <div class="card-header bg-white">
            <h5 class="mb-0"><?= esc($title) ?></h5>
        </div>

        <div class="card-body">
            <dl class="row mb-0">
                <?php foreach (array_slice($product, 1) as $key => $value) : ?>
                    <dt class="col-sm-4 text-muted text-capitalize">
                        <?= esc($labels[$key] ?? str_replace('_', ' ', $key)) ?>
                    </dt>
                    <dd class="col-sm-8"><?= esc($value) ?></dd>
                <?php endforeach ?>
            </dl>
        </div>

        <div class="card-footer bg-white text-end">
            <a href="<?= site_url('products/' . $product['id'] . '/edit') ?>" class="btn btn-primary">
                Modifier
            </a>
            <a href="<?= previous_url() ?? site_url('products') ?>" class="btn btn-outline-secondary">Fermer</a>
        </div>
    </div>
</div>

<?= $this->endSection() ?>