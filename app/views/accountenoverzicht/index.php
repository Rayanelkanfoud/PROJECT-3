<?php require_once __DIR__ . '/../../../includes/header.php'; ?>

<section class="accounts-hero">
    <div class="container">
        <p class="accounts-badge">Accounts overzicht</p>
        <h1>Bekijk alle accounts in het systeem</h1>
        <p class="accounts-intro">
            Hieronder zie je een overzicht van alle geregistreerde accounts met naam, e-mailadres, rol en status.
        </p>
    </div>
</section>

<section class="accounts-overzicht">
    <div class="container">
        <div class="accounts-tabel-wrapper">
            <table class="accounts-tabel">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Naam</th>
                        <th>E-mailadres</th>
                        <th>Rol</th>
                        <th>Actief</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($accounts as $account): ?>
                        <tr>
                            <td><?php echo $account['id']; ?></td>
                            <td><?php echo htmlspecialchars($account['volledige_naam']); ?></td>
                            <td><?php echo htmlspecialchars($account['email']); ?></td>
                            <td><?php echo htmlspecialchars($account['rol']); ?></td>
                            <td><?php echo $account['is_actief'] ? 'Ja' : 'Nee'; ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</section>

<?php require_once __DIR__ . '/../../../includes/footer.php'; ?>