<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="h3 mb-0">Produits</h1>
    <a href="<?= site_url('products/new') ?>" class="btn btn-primary">
        <i class="bi bi-plus-lg"></i> Nouveau produit
    </a>
</div>

<form method="get" action="<?= site_url('products') ?>" class="mb-3">
    <div class="input-group">
        <input type="search" name="q" class="form-control" placeholder="Rechercher un nom ou une référence."
            value="<?= esc($q) ?>">
        <button class="btn btn-outline-secondary"><i class="bi bi-search"></i></button>
        <?php if ($q !== ''): ?>
            <a href="<?= site_url('products') ?>" class="btn btn-outline-secondary">Effacer</a>
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
                <?php foreach ($products as $c): ?>
                    <tr>
                        <td class="fw-semibold">
                            <a href="<?= site_url('products/' . $c['id'] . '/show') ?>" title="Voir" class="font-monospace">
                                <?= esc($c['reference']) ?>
                            </a>
                        </td>
                        <td><?= esc($c['nom']) ?></td>
                        <td><?= esc($c['description']) ?></td>
                        <td><?= esc($c['prix_ht']) ?> €</td>
                        <td><?= number_format($c['prix_ht'] * (1 + ($c['taux_tva'] / 100)), 2, ',', ' ') ?> €</td>
                        <td><?= esc($c['stock']) ?></td>
                        <td><?= esc($c['actif']) ?></td>
                        <td class="text-end text-nowrap">
                            <a href="<?= site_url('products/' . $c['id'] . '/edit') ?>"
                                class="btn btn-sm btn-outline-primary" title="Modifier">
                                <i class="bi bi-pencil"></i>
                            </a>
                            <button type="button" class="btn btn-sm btn-outline-danger" title="Supprimer"
                                data-bs-toggle="modal" data-bs-target="#deleteModal"
                                data-action="<?= site_url('products/' . $c['id'] . '/delete') ?>"
                                data-name="<?= esc($c['nom']) ?>">
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
    <?= $pager->only(['q'])->links('default', 'bootstrap') ?>
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