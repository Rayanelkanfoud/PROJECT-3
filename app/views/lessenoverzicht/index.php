<?php require_once __DIR__ . '/../../../includes/header.php'; ?>

<section class="lessen-hero">
    <div class="container">
        <p class="lessen-badge">Lessen overzicht</p>
        <h1>Bekijk alle beschikbare lessen</h1>
        <p class="lessen-intro">
            Hieronder zie je een overzicht van alle lessen die momenteel in het systeem staan.
        </p>
    </div>
</section>

<section class="lessen-overzicht">
    <div class="container">
        <div class="lessen-tabel-wrapper">
            <table class="lessen-tabel">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Naam</th>
                        <th>Prijs</th>
                        <th>Datum</th>
                        <th>Tijd</th>
                        <th>Min</th>
                        <th>Max</th>
                        <th>Status</th>
                        <th>Aanbieding</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($lessen as $les): ?>
                        <tr>
                            <td><?php echo $les['id']; ?></td>
                            <td><?php echo htmlspecialchars($les['naam']); ?></td>
                            <td>€<?php echo number_format($les['prijs'], 2, ',', '.'); ?></td>
                            <td><?php echo htmlspecialchars($les['datum']); ?></td>
                            <td><?php echo htmlspecialchars($les['tijd']); ?></td>
                            <td><?php echo htmlspecialchars($les['min_aantal_personen']); ?></td>
                            <td><?php echo htmlspecialchars($les['max_aantal_personen']); ?></td>
                            <td><?php echo htmlspecialchars($les['status']); ?></td>
                            <td><?php echo $les['is_aanbieding'] ? 'Ja' : 'Nee'; ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</section>

<?php require_once __DIR__ . '/../../../includes/footer.php'; ?>