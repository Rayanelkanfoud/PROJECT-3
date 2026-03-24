<?php require APPROOT . '/views/includes/header.php'; ?>

<div class="d-flex justify-content-between align-items-center mb-3">
  <h1 class="page-title"><i class="bi bi-person-badge-fill"></i> Medewerkers beheer</h1>
  <a href="<?= URLROOT ?>/medewerker/create" class="btn btn-fitforfun">
    <i class="bi bi-plus-circle"></i> Nieuwe medewerker
  </a>
</div>

<?php $m = $_GET['melding'] ?? ''; ?>
<?php if ($m === 'toegevoegd'): ?><div class="alert alert-success"><i class="bi bi-check-circle"></i> Medewerker succesvol toegevoegd.</div><?php endif; ?>

<div class="card shadow-sm">
  <div class="card-body p-0">
    <table class="table table-hover mb-0">
      <thead>
        <tr>
          <th>#</th><th>Naam</th><th>E-mail</th><th>Status</th>
        </tr>
      </thead>
      <tbody>
        <?php if (empty($data['medewerkers'])): ?>
          <tr><td colspan="4" class="text-center text-muted py-4">Geen medewerkers gevonden.</td></tr>
        <?php else: ?>
          <?php foreach ($data['medewerkers'] as $mw): ?>
          <tr>
            <td class="text-muted"><?= $mw->Id ?></td>
            <td><strong><?= htmlspecialchars($mw->Naam) ?></strong></td>
            <td><?= htmlspecialchars($mw->Email) ?></td>
            <td><span class="badge badge-<?= $mw->Status ?>"><?= ucfirst($mw->Status) ?></span></td>
          </tr>
          <?php endforeach; ?>
        <?php endif; ?>
      </tbody>
    </table>
  </div>
</div>
<p class="text-muted mt-2 small"><?= count($data['medewerkers']) ?> medewerker(s) gevonden.</p>

<?php require APPROOT . '/views/includes/footer.php'; ?>
