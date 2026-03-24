<?php require APPROOT . '/views/includes/header.php'; ?>

<div class="d-flex justify-content-between align-items-center mb-3">
  <h1 class="page-title"><i class="bi bi-person-plus-fill"></i> Nieuw lid toevoegen</h1>
  <a href="<?= URLROOT ?>/lid/index" class="btn btn-outline-secondary">← Terug</a>
</div>

<?php if (!empty($data['fouten'])): ?>
  <div class="alert alert-danger">
    <ul class="mb-0">
      <?php foreach ($data['fouten'] as $f): ?><li><?= htmlspecialchars($f) ?></li><?php endforeach; ?>
    </ul>
  </div>
<?php endif; ?>

<div class="card shadow-sm" style="max-width:700px">
  <div class="card-body">
    <form method="POST" action="<?= URLROOT ?>/lid/create">
      <div class="row g-3">
        <div class="col-md-6">
          <label class="form-label fw-bold">Voornaam *</label>
          <input type="text" name="voornaam" class="form-control"
                 value="<?= htmlspecialchars($data['voornaam']) ?>" required>
        </div>
        <div class="col-md-6">
          <label class="form-label fw-bold">Achternaam *</label>
          <input type="text" name="achternaam" class="form-control"
                 value="<?= htmlspecialchars($data['achternaam']) ?>" required>
        </div>
        <div class="col-md-6">
          <label class="form-label fw-bold">E-mailadres *</label>
          <input type="email" name="email" class="form-control"
                 value="<?= htmlspecialchars($data['email']) ?>" required>
        </div>
        <div class="col-md-6">
          <label class="form-label fw-bold">Telefoonnummer</label>
          <input type="text" name="telefoon" class="form-control"
                 value="<?= htmlspecialchars($data['telefoon']) ?>" placeholder="06-12345678">
        </div>
        <div class="col-md-6">
          <label class="form-label fw-bold">Lid sinds *</label>
          <input type="date" name="lidsinds" class="form-control"
                 value="<?= $data['lidsinds'] ?>" required>
        </div>
        <div class="col-md-6">
          <label class="form-label fw-bold">Status *</label>
          <select name="status" class="form-select">
            <option value="actief"   <?= $data['status'] === 'actief'   ? 'selected' : '' ?>>Actief</option>
            <option value="inactief" <?= $data['status'] === 'inactief' ? 'selected' : '' ?>>Inactief</option>
          </select>
        </div>
      </div>
      <div class="mt-4">
        <button type="submit" class="btn btn-fitforfun">
          <i class="bi bi-check-circle"></i> Lid opslaan
        </button>
        <a href="<?= URLROOT ?>/lid/index" class="btn btn-outline-secondary ms-2">Annuleren</a>
      </div>
    </form>
  </div>
</div>

<?php require APPROOT . '/views/includes/footer.php'; ?>
