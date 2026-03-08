<?php require_once __DIR__ . '/../../../includes/header.php'; ?>

<section class="planning-hero">
    <div class="container">
        <p class="planning-badge">Overzicht geplande lessen</p>
        <h1>Bekijk alle geplande lessen</h1>
        <p class="planning-intro">
            Hieronder zie je een overzicht van alle lessen die op dit moment gepland staan in het systeem.
        </p>
    </div>
</section>

<section class="planning-overzicht">
    <div class="container">
        <div class="planning-tabel-wrapper">
            <table class="planning-tabel">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Naam</th>
                        <th>Datum</th>
                        <th>Tijd</th>
                        <th>Prijs</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($geplandeLessen as $les): ?>
                        <tr>
                            <td><?php echo $les['id']; ?></td>
                            <td><?php echo htmlspecialchars($les['naam']); ?></td>
                            <td><?php echo htmlspecialchars($les['datum']); ?></td>
                            <td><?php echo htmlspecialchars($les['tijd']); ?></td>
                            <td>€<?php echo number_format($les['prijs'], 2, ',', '.'); ?></td>
                            <td><?php echo htmlspecialchars($les['status']); ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</section>

<?php require_once __DIR__ . '/../../../includes/footer.php'; ?>