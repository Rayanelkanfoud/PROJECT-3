<?php require_once __DIR__ . '/../../../includes/header.php'; ?>

<section class="zoeken-hero">
    <div class="container">
        <p class="zoeken-badge">Zoeken op les naam</p>
        <h1>Zoek snel een les op naam</h1>
        <p class="zoeken-intro">
            Vul hieronder de naam van een les in en bekijk direct de resultaten.
        </p>
    </div>
</section>

<section class="zoeken-sectie">
    <div class="container">
        <div class="zoeken-box">
            <form method="POST" action="" class="zoeken-formulier">
                <label for="zoekterm">Lesnaam</label>
                <input
                    type="text"
                    id="zoekterm"
                    name="zoekterm"
                    placeholder="Bijvoorbeeld Yoga of Bootcamp"
                    value="<?php echo htmlspecialchars($zoekterm); ?>"
                >
                <button type="submit" class="button-primary">Zoeken</button>
            </form>

            <?php if ($foutmelding !== ''): ?>
                <div class="zoeken-melding zoeken-melding--fout">
                    <?php echo htmlspecialchars($foutmelding); ?>
                </div>
            <?php endif; ?>

            <?php if (!empty($resultaten)): ?>
                <div class="zoeken-resultaten">
                    <h2>Gevonden lessen</h2>

                    <div class="zoeken-tabel-wrapper">
                        <table class="zoeken-tabel">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Naam</th>
                                    <th>Prijs</th>
                                    <th>Datum</th>
                                    <th>Tijd</th>
                                    <th>Status</th>
                                    <th>Aanbieding</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($resultaten as $les): ?>
                                    <tr>
                                        <td><?php echo $les['id']; ?></td>
                                        <td><?php echo htmlspecialchars($les['naam']); ?></td>
                                        <td>€<?php echo number_format($les['prijs'], 2, ',', '.'); ?></td>
                                        <td><?php echo htmlspecialchars($les['datum']); ?></td>
                                        <td><?php echo htmlspecialchars($les['tijd']); ?></td>
                                        <td><?php echo htmlspecialchars($les['status']); ?></td>
                                        <td><?php echo $les['is_aanbieding'] ? 'Ja' : 'Nee'; ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            <?php elseif ($heeftGezocht && $foutmelding === ''): ?>
                <div class="zoeken-melding">
                    Er zijn geen resultaten gevonden.
                </div>
            <?php endif; ?>
        </div>
    </div>
</section>

<?php require_once __DIR__ . '/../../../includes/footer.php'; ?>