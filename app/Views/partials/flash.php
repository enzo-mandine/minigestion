<?php
// Messages "passagers" : affichés en toast
$toasts = [
    'success' => ['bg' => 'success', 'icon' => 'check-circle', 'close' => 'btn-close-white'],
    'info'    => ['bg' => 'info',    'icon' => 'info-circle',  'close' => ''],
];

// Messages importants : alertes qui restent affichées
$alerts = [
    'error'   => ['class' => 'danger',  'icon' => 'exclamation-triangle'],
    'warning' => ['class' => 'warning', 'icon' => 'exclamation-circle'],
];
?>

<?php foreach ($alerts as $key => $a): ?>
    <?php if (session()->getFlashdata($key)): ?>
        <div class="alert alert-<?= $a['class'] ?> alert-dismissible fade show">
            <i class="bi bi-<?= $a['icon'] ?>"></i> <?= esc(session()->getFlashdata($key)) ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    <?php endif ?>
<?php endforeach ?>

<?php if (session('errors')): ?>
    <div class="alert alert-danger">
        <i class="bi bi-x-circle"></i> Le formulaire contient des erreurs, merci de les corriger.
    </div>
<?php endif ?>

<div class="toast-container position-fixed bottom-0 end-0 p-3">
    <?php foreach ($toasts as $key => $t): ?>
        <?php if (session()->getFlashdata($key)): ?>
            <div class="toast align-items-center text-bg-<?= $t['bg'] ?> border-0"
                role="alert" aria-live="polite" aria-atomic="true" data-bs-delay="4000">
                <div class="d-flex">
                    <div class="toast-body">
                        <i class="bi bi-<?= $t['icon'] ?>"></i> <?= esc(session()->getFlashdata($key)) ?>
                    </div>
                    <button type="button" class="btn-close <?= $t['close'] ?> me-2 m-auto" data-bs-dismiss="toast"></button>
                </div>
            </div>
        <?php endif ?>
    <?php endforeach ?>
</div>