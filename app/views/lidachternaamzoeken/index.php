<?php require_once __DIR__ . '/../../../includes/header.php'; ?>

<section class="lidzoeken-hero">
    <div class="container">
        <p class="lidzoeken-badge">Lid op achternaam zoeken</p>
        <h1>Zoek snel een lid op achternaam</h1>
        <p class="lidzoeken-intro">
            Vul hieronder een achternaam in en bekijk direct welke leden gevonden zijn.
        </p>
    </div>
</section>

<section class="lidzoeken-sectie">
    <div class="container">
        <div class="lidzoeken-box">
            <form method="POST" action="" class="lidzoeken-formulier">
                <label for="zoekterm">Achternaam</label>
                <input
                    type="text"
                    id="zoekterm"
                    name="zoekterm"
                    placeholder="Bijvoorbeeld Jansen of Bakker"
                    value="<?php echo htmlspecialchars($zoekterm); ?>"
                >
                <button type="submit" class="button-primary">Zoeken</button>
            </form>

            <?php if ($foutmelding !== ''): ?>
                <div class="lidzoeken-melding lidzoeken-melding--fout">
                    <?php echo htmlspecialchars($foutmelding); ?>
                </div>
            <?php endif; ?>

            <?php if (!empty($resultaten)): ?>
                <div class="lidzoeken-resultaten">
                    <h2>Gevonden leden</h2>

                    <div class="lidzoeken-tabel-wrapper">
                        <table class="lidzoeken-tabel">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Voornaam</th>
                                    <th>Tussenvoegsel</th>
                                    <th>Achternaam</th>
                                    <th>E-mailadres</th>
                                    <th>Mobiel</th>
                                    <th>Relatienummer</th>
                                    <th>Actief</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($resultaten as $lid): ?>
                                    <tr>
                                        <td><?php echo $lid['id']; ?></td>
                                        <td><?php echo htmlspecialchars($lid['voornaam']); ?></td>
                                        <td><?php echo htmlspecialchars($lid['tussenvoegsel'] ?? ''); ?></td>
                                        <td><?php echo htmlspecialchars($lid['achternaam']); ?></td>
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
            <?php elseif ($heeftGezocht && $foutmelding === ''): ?>
                <div class="lidzoeken-melding">
                    Er zijn geen resultaten gevonden.
                </div>
            <?php endif; ?>
        </div>
    </div>
</section>

<?php require_once __DIR__ . '/../../../includes/footer.php'; ?>