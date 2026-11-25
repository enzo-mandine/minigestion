<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<div class="dflex justify-content-between align-items-center mb-4">
    <h1 class="h3 mb-0"><?= $title ?></h1>
    <p class="mb-0"><?= $content ?></p>
</div>
<?= $this->endSection() ?>