<?php require APPROOT . '/views/includes/header.php'; ?>

<div class="d-flex justify-content-between align-items-center mb-3">
  <h1 class="page-title"><i class="bi bi-people-fill"></i> Leden beheer</h1>
  <a href="<?= URLROOT ?>/lid/create" class="btn btn-fitforfun">
    <i class="bi bi-plus-circle"></i> Nieuw lid
  </a>
</div>

<?php $m = $_GET['melding'] ?? ''; ?>
<?php if ($m === 'toegevoegd'): ?><div class="alert alert-success"><i class="bi bi-check-circle"></i> Lid succesvol toegevoegd.</div><?php endif; ?>
<?php if ($m === 'bijgewerkt'): ?><div class="alert alert-success"><i class="bi bi-check-circle"></i> Lid succesvol bijgewerkt.</div><?php endif; ?>
<?php if ($m === 'verwijderd'): ?><div class="alert alert-warning"><i class="bi bi-trash"></i> Lid verwijderd.</div><?php endif; ?>

<!-- Zoekformulier -->
<form method="GET" action="<?= URLROOT ?>/lid/index" class="d-flex gap-2 mb-3">
  <input type="text" name="zoek" class="form-control w-auto"
         placeholder="Zoek op achternaam..."
         value="<?= htmlspecialchars($data['zoek'] ?? '') ?>">
  <button type="submit" class="btn btn-fitforfun"><i class="bi bi-search"></i> Zoeken</button>
  <?php if (!empty($data['zoek'])): ?>
    <a href="<?= URLROOT ?>/lid/index" class="btn btn-outline-secondary">✕ Reset</a>
  <?php endif; ?>
</form>

<div class="card shadow-sm">
  <div class="card-body p-0">
    <table class="table table-hover mb-0">
      <thead>
        <tr>
          <th>#</th><th>Naam</th><th>E-mail</th><th>Telefoon</th>
          <th>Lid sinds</th><th>Status</th><th>Acties</th>
        </tr>
      </thead>
      <tbody>
        <?php if (empty($data['leden'])): ?>
          <tr><td colspan="7" class="text-center text-muted py-4">Geen leden gevonden.</td></tr>
        <?php else: ?>
          <?php foreach ($data['leden'] as $lid): ?>
          <tr>
            <td class="text-muted"><?= $lid->Id ?></td>
            <td><strong><?= htmlspecialchars($lid->Voornaam . ' ' . $lid->Achternaam) ?></strong></td>
            <td><?= htmlspecialchars($lid->Email) ?></td>
            <td><?= htmlspecialchars($lid->Telefoon ?? '—') ?></td>
            <td><?= htmlspecialchars($lid->LidSinds) ?></td>
            <td><span class="badge badge-<?= $lid->Status ?>"><?= ucfirst($lid->Status) ?></span></td>
            <td>
              <a href="<?= URLROOT ?>/lid/edit/<?= $lid->Id ?>" class="btn btn-sm btn-outline-warning">
                <i class="bi bi-pencil"></i> Bewerken
              </a>
              <a href="<?= URLROOT ?>/lid/delete/<?= $lid->Id ?>"
                 class="btn btn-sm btn-outline-danger"
                 onclick="return confirm('Lid <?= htmlspecialchars($lid->Voornaam) ?> verwijderen?')">
                <i class="bi bi-trash"></i> Verwijderen
              </a>
            </td>
          </tr>
          <?php endforeach; ?>
        <?php endif; ?>
      </tbody>
    </table>
  </div>
</div>
<p class="text-muted mt-2 small"><?= count($data['leden']) ?> lid(en) gevonden.</p>

<?php require APPROOT . '/views/includes/footer.php'; ?>
