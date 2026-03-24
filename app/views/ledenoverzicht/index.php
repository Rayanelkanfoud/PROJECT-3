<?php require_once __DIR__ . '/../../../includes/header.php'; ?>

<section class="leden-hero">
    <div class="container">
        <p class="leden-badge">Leden overzicht</p>
        <h1>Bekijk alle leden in het systeem</h1>
        <p class="leden-intro">
            Hieronder zie je een overzicht van alle leden met naam, e-mailadres, mobiel nummer, relatienummer en status.
        </p>
    </div>
</section>

<section class="leden-overzicht">
    <div class="container">
        <div class="leden-tabel-wrapper">
            <table class="leden-tabel">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Naam</th>
                        <th>E-mailadres</th>
                        <th>Mobiel</th>
                        <th>Relatienummer</th>
                        <th>Actief</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($leden as $lid): ?>
                        <tr>
                            <td><?php echo $lid['id']; ?></td>
                            <td><?php echo htmlspecialchars($lid['volledige_naam']); ?></td>
                            <td><?php echo htmlspecialchars($lid['email']); ?></td>
                            <td><?php echo htmlspecialchars($lid['mobiel']); ?></td>
                            <td><?php echo htmlspecialchars($lid['relatienummer']); ?></td>
                            <td><?php echo $lid['is_actief'] ? 'Ja' : 'Nee'; ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</section>

<?php require_once __DIR__ . '/../../../includes/footer.php'; ?>