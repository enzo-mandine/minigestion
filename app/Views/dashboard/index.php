<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>

<h1 class="h3 mb-4">Tableau de bord</h1>

<div class="row g-3">
    <?php foreach ($stats as $label => $valeur): ?>
        <?php if ($label === 'ruptures') {
            continue;
        } ?>
        <div class="col-md-4">
            <div class="card shadow-sm border-0">
                <div class="card-body">
                    <?php if ($label === 'produits'): ?>
                        <div class="row align-items-center text-center">
                            <div class="col-6 border-end">
                                <div class="text-muted text-uppercase small">Produits</div>
                                <div class="display-6 fw-bold"><?= esc($valeur) ?></div>
                            </div>
                            <div class="col-6">
                                <div class="text-muted text-uppercase small">Ruptures</div>
                                <div class="display-6 fw-bold text-danger"><?= esc($stats['ruptures']) ?></div>
                            </div>
                        </div>
                    <?php else: ?>
                        <div class="text-muted text-uppercase small"><?= esc($label) ?></div>
                        <div class="display-6 fw-bold"><?= esc($valeur) ?></div>
                    <?php endif ?>
                </div>
            </div>
        </div>
    <?php endforeach ?>
</div>

<?= $this->endSection() ?>