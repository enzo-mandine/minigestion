<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>

<h1 class="h3 mb-4">Tableau de bord</h1>

<div class="row g-3">
    <?php foreach ($stats as $label => $valeur): ?>
        <div class="col-md-4">
            <div class="card shadow-sm border-0">
                <div class="card-body">
                    <div class="text-muted text-uppercase small"><?= esc($label) ?></div>
                    <div class="display-6 fw-bold"><?= esc($valeur) ?></div>
                </div>
            </div>
        </div>
    <?php endforeach ?>
</div>

<?= $this->endSection() ?>