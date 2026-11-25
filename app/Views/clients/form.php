<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>

<?php
$errors = session('errors') ?? [];
$isEdit = $client !== null;
$action = $isEdit ? site_url('clients/' . $client['id'] . '/update') : site_url('clients');

$fields = [
    'nom'        => ['label' => 'Nom *',      'type' => 'text'],
    'prenom'     => ['label' => 'Prénom',     'type' => 'text'],
    'email'      => ['label' => 'Email *',    'type' => 'email'],
    'telephone'  => ['label' => 'Téléphone',  'type' => 'tel'],
    'entreprise' => ['label' => 'Entreprise', 'type' => 'text'],
    'ville'      => ['label' => 'Ville',      'type' => 'text'],
];
?>

<h1 class="h3 mb-4"><?= esc($title) ?></h1>

<div class="card shadow-sm border-0">
    <div class="card-body">
        <form action="<?= $action ?>" method="post" novalidate>
            <?= csrf_field() ?>

            <div class="row g-3">
                <?php foreach ($fields as $name => $f): ?>
                    <div class="col-md-6">
                        <label for="<?= $name ?>" class="form-label"><?= $f['label'] ?></label>
                        <input type="<?= $f['type'] ?>" id="<?= $name ?>" name="<?= $name ?>"
                            class="form-control <?= isset($errors[$name]) ? 'is-invalid' : '' ?>"
                            value="<?= esc(old($name, $client[$name] ?? '')) ?>">
                        <div class="invalid-feedback"><?= esc($errors[$name] ?? '') ?></div>
                    </div>
                <?php endforeach ?>
            </div>

            <div class="mt-4 d-flex gap-2 justify-content-end">
                <button class="btn btn-primary">
                    <i class="bi bi-check-lg"></i> <?= $isEdit ? 'Enregistrer' : 'Créer' ?>
                </button>
                <a href="<?= previous_url() ?? site_url('clients') ?>" class="btn btn-outline-secondary">Annuler</a>
            </div>
        </form>
    </div>
</div>

<?= $this->endSection() ?>