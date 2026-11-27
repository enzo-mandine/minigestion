<?php if ($produit->etatStock() === 'rupture'): ?>
    <span class="badge text-bg-danger">Rupture</span>
<?php elseif ($produit->etatStock() === 'faible'): ?>
    <span class="badge text-bg-warning"><?= esc($produit->stock) ?></span>
<?php else: ?>
    <span class="badge text-bg-success"><?= esc($produit->stock) ?></span>
<?php endif ?>