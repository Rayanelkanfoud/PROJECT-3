<?php require_once __DIR__ . '/../../../includes/header.php'; ?>

<section class="reserveringen-hero">
    <div class="container">
        <p class="reserveringen-badge">Reservering overzicht</p>
        <h1>Bekijk alle reserveringen in het systeem</h1>
        <p class="reserveringen-intro">
            Hieronder zie je een overzicht van alle reserveringen met lid, les, datum, tijd en status.
        </p>
    </div>
</section>

<section class="reserveringen-overzicht">
    <div class="container">
        <div class="reserveringen-tabel-wrapper">
            <table class="reserveringen-tabel">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Lid</th>
                        <th>Les</th>
                        <th>Datum</th>
                        <th>Tijd</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($reserveringen)): ?>
                        <tr><td colspan="6" style="text-align:center; padding:20px;">Geen reserveringen gevonden.</td></tr>
                    <?php else: ?>
                        <?php foreach ($reserveringen as $reservering): ?>
                            <tr>
                                <td><?php echo $reservering['id']; ?></td>
                                <td><?php echo htmlspecialchars($reservering['lid_naam']); ?></td>
                                <td><?php echo htmlspecialchars($reservering['les_naam']); ?></td>
                                <td><?php echo htmlspecialchars($reservering['datum']); ?></td>
                                <td><?php echo htmlspecialchars($reservering['tijd']); ?></td>
                                <td><?php echo htmlspecialchars($reservering['reserveringsstatus']); ?></td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</section>

<?php require_once __DIR__ . '/../../../includes/footer.php'; ?>