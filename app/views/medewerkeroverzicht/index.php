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
                    <?php if (empty($medewerkers)): ?>
                        <tr><td colspan="6" style="text-align:center; padding:20px;">Geen medewerkers gevonden.</td></tr>
                    <?php else: ?>
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
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</section>

<section class="medewerker-toevoegen">
    <div class="container">
        <div class="medewerker-formulier-box">
            <h2>Nieuwe medewerker toevoegen</h2>

            <?php if ($succesmelding !== ''): ?>
                <div class="medewerker-melding medewerker-melding--succes">
                    <?php echo htmlspecialchars($succesmelding); ?>
                </div>
            <?php endif; ?>

            <?php if ($foutmelding !== ''): ?>
                <div class="medewerker-melding medewerker-melding--fout">
                    <?php echo htmlspecialchars($foutmelding); ?>
                </div>
            <?php endif; ?>

            <form method="POST" action="" class="medewerker-formulier">
                <div class="medewerker-formulier-grid">
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
                        <label for="medewerkersoort">Functie *</label>
                        <input type="text" id="medewerkersoort" name="medewerkersoort" value="<?php echo htmlspecialchars($medewerkersoort); ?>">
                    </div>
                    <div>
                        <label for="telefoonnummer">Telefoonnummer</label>
                        <input type="text" id="telefoonnummer" name="telefoonnummer" value="<?php echo htmlspecialchars($telefoonnummer); ?>">
                    </div>
                </div>
                <button type="submit" class="button-primary">Opslaan</button>
            </form>
        </div>
    </div>
</section>

<?php require_once __DIR__ . '/../../../includes/footer.php'; ?>