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
                    <?php if (empty($leden)): ?>
                        <tr><td colspan="6" style="text-align:center; padding:20px;">Geen leden gevonden.</td></tr>
                    <?php else: ?>
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
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</section>

<section class="lid-toevoegen">
    <div class="container">
        <div class="lid-formulier-box">
            <h2>Nieuw lid toevoegen</h2>

            <?php if ($succesmelding !== ''): ?>
                <div class="lid-melding lid-melding--succes">
                    <?php echo htmlspecialchars($succesmelding); ?>
                </div>
            <?php endif; ?>

            <?php if ($foutmelding !== ''): ?>
                <div class="lid-melding lid-melding--fout">
                    <?php echo htmlspecialchars($foutmelding); ?>
                </div>
            <?php endif; ?>

            <form method="POST" action="" class="lid-formulier">
                <div class="lid-formulier-grid">
                    <div>
                        <label for="voornaam">Voornaam *</label>
                        <input type="text" id="voornaam" name="voornaam" value="<?php echo htmlspecialchars($voornaam); ?>">
                    </div>
                    <div>
                        <label for="tussenvoegsel">Tussenvoegsel</label>
                        <input type="text" id="tussenvoegsel" name="tussenvoegsel" value="<?php echo htmlspecialchars($tussenvoegsel); ?>">
                    </div>
                    <div>
                        <label for="achternaam">Achternaam *</label>
                        <input type="text" id="achternaam" name="achternaam" value="<?php echo htmlspecialchars($achternaam); ?>">
                    </div>
                    <div>
                        <label for="email">E-mailadres *</label>
                        <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($email); ?>">
                    </div>
                    <div>
                        <label for="wachtwoord">Wachtwoord * (min. 8 tekens)</label>
                        <input type="password" id="wachtwoord" name="wachtwoord">
                    </div>
                    <div>
                        <label for="mobiel">Mobiel</label>
                        <input type="text" id="mobiel" name="mobiel" value="<?php echo htmlspecialchars($mobiel); ?>">
                    </div>
                    <div>
                        <label for="relatienummer">Relatienummer</label>
                        <input type="text" id="relatienummer" name="relatienummer" value="<?php echo htmlspecialchars($relatienummer); ?>">
                    </div>
                </div>
                <button type="submit" class="button-primary">Opslaan</button>
            </form>
        </div>
    </div>
</section>

<?php require_once __DIR__ . '/../../../includes/footer.php'; ?>