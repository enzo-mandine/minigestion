<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>

<?php $errors = session('errors') ?? []; ?>

<div class="row justify-content-center">
    <div class="col-sm-10 col-md-6 col-lg-4">
        <div class="card shadow-sm border-0 mt-4">
            <div class="card-body p-4">
                <h1 class="h4 text-center mb-4"><i class="bi bi-lock"></i> Connexion</h1>

                <form action="<?= site_url('login') ?>" method="post" novalidate>
                    <?= csrf_field() ?>

                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" id="email" name="email" autofocus
                            class="form-control <?= isset($errors['email']) ? 'is-invalid' : '' ?>"
                            value="<?= esc(session('login_email') ?? '') ?>">
                        <div class="invalid-feedback"><?= esc($errors['email'] ?? '') ?></div>
                    </div>

                    <div class="mb-4">
                        <label for="password" class="form-label">Mot de passe</label>
                        <input type="password" id="password" name="password"
                            class="form-control <?= isset($errors['password']) ? 'is-invalid' : '' ?>">
                        <div class="invalid-feedback"><?= esc($errors['password'] ?? '') ?></div>
                    </div>

                    <button class="btn btn-primary w-100">
                        <i class="bi bi-box-arrow-in-right"></i> Se connecter
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>