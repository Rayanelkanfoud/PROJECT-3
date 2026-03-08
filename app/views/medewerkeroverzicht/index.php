<?php require_once __DIR__ . '/../../../includes/header.php'; ?>

<section class="medewerkers-hero">
    <div class="container">
        <p class="medewerkers-badge">Medewerker overzicht</p>
        <h1>Bekijk alle medewerkers in het systeem</h1>
        <p class="medewerkers-intro">
            Hieronder zie je een overzicht van alle medewerkers met naam, functie, e-mailadres, telefoonnummer en status.
        </p>
    </div>
</section>

<section class="medewerkers-overzicht">
    <div class="container">
        <div class="medewerkers-tabel-wrapper">
            <table class="medewerkers-tabel">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Naam</th>
                        <th>Functie</th>
                        <th>E-mailadres</th>
                        <th>Telefoonnummer</th>
                        <th>Actief</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($medewerkers as $medewerker): ?>
                        <tr>
                            <td><?php echo $medewerker['id']; ?></td>
                            <td><?php echo htmlspecialchars($medewerker['volledige_naam']); ?></td>
                            <td><?php echo htmlspecialchars($medewerker['medewerkersoort']); ?></td>
                            <td><?php echo htmlspecialchars($medewerker['email']); ?></td>
                            <td><?php echo htmlspecialchars($medewerker['telefoonnummer']); ?></td>
                            <td><?php echo $medewerker['is_actief'] ? 'Ja' : 'Nee'; ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</section>

<?php require_once __DIR__ . '/../../../includes/footer.php'; ?>