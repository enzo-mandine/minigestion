<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>

<?php
$errors = session('errors') ?? [];
$isEdit = $product !== null;
$action = $isEdit ? site_url('products/' . $product['id'] . '/update') : site_url('products');

$fields = [
    'nom'         => ['label' => 'Nom *',      'type' => 'text'],
    'reference'   => ['label' => 'Référence *', 'type' => 'text'],
    'description' => ['label' => 'Description',    'type' => 'text'],
    'prix_ht'     => ['label' => 'Prix H.T. *', 'type' => 'number'],
    'taux_tva'    => [
        'label' => 'Taux T.V.A',
        'type'  => 'select',
        'options' => [
            '0',
            '5.5',
            '10',
            '20',
        ],
    ],
    'stock'       => ['label' => 'Stock', 'type' => 'number'],
    'actif'       => ['label' => 'Actif',      'type' => 'text'],
];
?>

<h1 class="h3 mb-4"><?= esc($title) ?></h1>

<div class="card shadow-sm border-0">
    <div class="card-body">
        <form action="<?= $action ?>" method="post" novalidate>
            <?= csrf_field() ?>

            <div class="row g-3">
                <?php foreach ($fields as $name => $f): ?>
                    <?php if ($f['type'] === 'select'): ?>
                        <div class="col-md-6">
                            <label for="<?= $name ?>" class="form-label"><?= $f['label'] ?></label>

                            <?php $currentValue = old($name, $product[$name] ?? '20'); ?>

                            <select id="<?= $name ?>" name="<?= $name ?>" class="form-select <?= isset($errors[$name]) ? 'is-invalid' : '' ?>">
                                <?php foreach ($f['options'] as $value) : ?>
                                    <option value="<?= esc($value) ?>" <?= ($currentValue == $value) ? 'selected' : '' ?>>
                                        <?= esc($value) ?> %
                                    </option>
                                <?php endforeach ?>
                            </select>
                            <div class="invalid-feedback"><?= esc($errors[$name] ?? '') ?></div>
                        </div>
                    <?php elseif ($name === 'actif'): ?>
                        <input type="hidden" name="actif" value="0">
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" id="actif" name="actif" value="1"
                                <?= old('actif', $product['actif'] ?? '1') == '1' ? 'checked' : '' ?>>
                            <label class="form-check-label" for="actif">Actif</label>
                        </div>
                    <?php else : ?>
                        <div class="col-md-6">
                            <label for="<?= $name ?>" class="form-label"><?= $f['label'] ?></label>
                            <input type="<?= $f['type'] ?>" id="<?= $name ?>" name="<?= $name ?>"
                                class="form-control <?= isset($errors[$name]) ? 'is-invalid' : '' ?>"
                                value="<?= esc(old($name, $product[$name] ?? '')) ?>"
                                step="<?= $name === "prix_ht" ? '0.01' : '' ?>">
                            <div class="invalid-feedback"><?= esc($errors[$name] ?? '') ?></div>
                        </div>
                    <?php endif ?>
                <?php endforeach ?>
            </div>

            <div class="mt-4 d-flex gap-2 justify-content-end">
                <button class="btn btn-primary">
                    <i class="bi bi-check-lg"></i> <?= $isEdit ? 'Enregistrer' : 'Créer' ?>
                </button>
                <a href="<?= previous_url() ?? site_url('products') ?>" class="btn btn-outline-secondary">Annuler</a>
            </div>
        </form>
    </div>
</div>

<?= $this->endSection() ?>