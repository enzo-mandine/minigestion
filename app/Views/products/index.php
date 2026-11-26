<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="h3 mb-0">Produits</h1>
    <a href="<?= site_url('produits/new') ?>" class="btn btn-primary">
        <i class="bi bi-plus-lg"></i> Nouveau produit
    </a>
</div>

<form method="get" action="<?= site_url('produits') ?>" class="mb-3">
    <div class="input-group">
        <div class="input-group-text bg-white">
            <input <?= $actifs ? 'checked' : '' ?> onchange="this.form.submit()"
                class="form-check-input mt-0 me-2" type="checkbox" id="actifs" name="actifs" value="1">
            <label class="form-check-label" for="actifs" style="cursor: pointer;">Actifs seulement</label>
        </div>
        <input type="search" name="q" class="form-control" placeholder="Rechercher un nom ou une référence."
            value="<?= esc($q) ?>">
        <button class="btn btn-outline-secondary"><i class="bi bi-search"></i></button>
        <?php if ($q !== ''): ?>
            <a href="<?= site_url('produits') ?>" class="btn btn-outline-secondary">Effacer</a>
        <?php endif ?>
    </div>
</form>

<div class="card shadow-sm border-0">
    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0">
            <thead class="table-light">
                <tr>
                    <th>Référence</th>
                    <th>Nom</th>
                    <th>Description</th>
                    <th>Prix H.T.</th>
                    <th>Prix T.T.C.</th>
                    <th>Stock</th>
                    <th>Actif</th>
                    <th class="text-end">Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($products as $p): ?>
                    <tr>
                        <td class="fw-semibold">
                            <a href="<?= site_url('produits/' . $p['id'] . '/show') ?>" title="Voir" class="font-monospace">
                                <?= esc($p['reference']) ?>
                            </a>
                        </td>
                        <td><?= esc($p['nom']) ?></td>
                        <td><?= esc(character_limiter($p['description'] ?? '', 80, '…')) ?></td>
                        <td><?= number_to_currency((float) $p['prix_ht'], 'EUR', null, 2) ?></td>
                        <td><?= number_to_currency(round($p['prix_ht'] * (1 + $p['taux_tva'] / 100), 2), 'EUR', null, 2) ?></td>
                        <td>
                            <?php if ($p['stock'] == 0): ?>
                                <span class="badge text-bg-danger"><i class="bi bi-boxes"></i></span>
                            <?php elseif ($p['stock'] <= 5): ?>
                                <span class="badge text-bg-warning"><i class="bi bi-boxes"></i></span>
                            <?php else : ?>
                                <span class="badge text-bg-success"><i class="bi bi-boxes"></i></span>
                            <?php endif ?>
                        </td>
                        <?php if ($p['actif'] == '1'): ?>
                            <td><span class="badge text-bg-primary">Actif</span></td>
                        <?php else : ?>
                            <td><span class="badge text-bg-secondary">Inactif</span></td>
                        <?php endif ?>
                        <td class="text-end text-nowrap">
                            <a href="<?= site_url('produits/' . $p['id'] . '/edit') ?>"
                                class="btn btn-sm btn-outline-primary" title="Modifier">
                                <i class="bi bi-pencil"></i>
                            </a>
                            <button type="button" class="btn btn-sm btn-outline-danger" title="Supprimer"
                                data-bs-toggle="modal" data-bs-target="#deleteModal"
                                data-action="<?= site_url('produits/' . $p['id'] . '/delete') ?>"
                                data-name="<?= esc($p['nom']) ?>">
                                <i class="bi bi-trash"></i>
                            </button>
                        </td>
                    </tr>
                <?php endforeach ?>

                <?php if (empty($products)): ?>
                    <tr>
                        <td colspan="8" class="text-center text-muted py-4">Aucun produit trouvé.</td>
                    </tr>
                <?php endif ?>
            </tbody>
        </table>
    </div>
</div>

<div class="mt-3">
    <?= $pager->only(['q', 'actifs'])->links('default', 'bootstrap') ?>
</div>

<div class="modal fade" id="deleteModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <form method="post" class="modal-content" id="deleteForm">
            <?= csrf_field() ?>
            <div class="modal-header">
                <h5 class="modal-title"><i class="bi bi-exclamation-triangle text-danger"></i> Confirmer la suppression</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                Supprimer définitivement <strong id="deleteName"></strong> ?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Annuler</button>
                <button type="submit" class="btn btn-danger"><i class="bi bi-trash"></i> Supprimer</button>
            </div>
        </form>
    </div>
</div>

<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>
    document.getElementById('deleteModal').addEventListener('show.bs.modal', (event) => {
        const btn = event.relatedTarget;
        document.getElementById('deleteForm').action = btn.dataset.action;
        document.getElementById('deleteName').textContent = btn.dataset.name;
    });
</script>
<?= $this->endSection() ?>