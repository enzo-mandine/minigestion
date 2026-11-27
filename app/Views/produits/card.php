<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>

<?php
$labels = [
    'reference'     => 'Référence',
    'nom'           => 'Nom',
    'description'   => 'Description',
    'prix_ht'       => 'Prix H.T.',
    'prix_ttc'      => 'Prix T.T.C.',
    'taux_tva'      => 'Taux T.V.A.',
    'stock'         => 'Stock',
    'actif'         => 'Actif',
    'created_at'    => 'Date de création',
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
                <dt class="col-sm-4 text-muted text-capitalize"><?= esc($labels['reference']) ?></dt>
                <dd class="col-sm-8 fw-semibold font-monospace"><?= esc($produit->reference) ?></dd>
            </dl>

            <dl class="row mb-0">
                <dt class="col-sm-4 text-muted text-capitalize"><?= esc($labels['nom']) ?></dt>
                <dd class="col-sm-8"><?= esc($produit->nom) ?></dd>
            </dl>

            <dl class="row mb-0">
                <dt class="col-sm-4 text-muted text-capitalize"><?= esc($labels['description']) ?></dt>
                <dd class="col-sm-8"><?= esc($produit->description ?? '') ?></dd>
            </dl>

            <dl class="row mb-0">
                <dt class="col-sm-4 text-muted text-capitalize"><?= esc($labels['prix_ht']) ?></dt>
                <dd class="col-sm-8"><?= number_to_currency($produit->prix_ht, 'EUR', null, 2) ?></dd>
            </dl>

            <dl class="row mb-0">
                <dt class="col-sm-4 text-muted text-capitalize"><?= esc($labels['prix_ttc']) ?></dt>
                <dd class="col-sm-8"><?= number_to_currency($produit->prix_ttc, 'EUR', null, 2) ?></dd>
            </dl>

            <dl class="row mb-0">
                <dt class="col-sm-4 text-muted text-capitalize"><?= esc($labels['taux_tva']) ?></dt>
                <dd class="col-sm-8"><?= esc(number_format($produit->taux_tva, 1, ',', '')) ?> %</dd>
            </dl>

            <dl class="row mb-0">
                <dt class="col-sm-4 text-muted text-capitalize"><?= esc($labels['stock']) ?></dt>
                <dd class="col-sm-8">
                    <?php if ($produit->stock === 0): ?>
                        <span class="badge text-bg-danger">Rupture</span>
                    <?php elseif ($produit->stock < 5): ?>
                        <span class="badge text-bg-warning"><?= esc($produit->stock) ?></span>
                    <?php else: ?>
                        <span class="badge text-bg-success"><?= esc($produit->stock) ?></span>
                    <?php endif ?>
                </dd>
            </dl>

            <dl class="row mb-0">
                <dt class="col-sm-4 text-muted text-capitalize"><?= esc($labels['actif']) ?></dt>
                <dd class="col-sm-8">
                    <?php if ($produit->actif): ?>
                        <span class="badge text-bg-primary">Actif</span>
                    <?php else: ?>
                        <span class="badge text-bg-secondary">Inactif</span>
                    <?php endif ?>
                </dd>
            </dl>

            <dl class="row mb-0">
                <dt class="col-sm-4 text-muted text-capitalize"><?= esc($labels['created_at']) ?></dt>
                <dd class="col-sm-8"><?= esc($produit->created_at?->format('d/m/Y à H:i') ?? '—') ?></dd>
            </dl>

            <dl class="row mb-0">
                <dt class="col-sm-4 text-muted text-capitalize"><?= esc($labels['updated_at']) ?></dt>
                <dd class="col-sm-8"><?= esc($produit->updated_at?->format('d/m/Y à H:i') ?? '—') ?></dd>
            </dl>
        </div>

        <div class="card-footer bg-white text-end">
            <a href="<?= site_url('produits/' . $produit->id . '/edit') ?>" class="btn btn-primary">
                Modifier
            </a>
            <a href="<?= site_url('produits') ?>" class="btn btn-outline-secondary">Fermer</a>
        </div>
    </div>
</div>

<?= $this->endSection() ?>