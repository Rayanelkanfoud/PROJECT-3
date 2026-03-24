<?php require_once __DIR__ . '/../../../includes/header.php'; ?>

<section class="nieuwlid-hero">
    <div class="container">
        <p class="nieuwlid-badge">Nieuw lid toevoegen</p>
        <h1>Voeg een nieuw lid toe aan het systeem</h1>
        <p class="nieuwlid-intro">
            Vul het formulier in om een nieuw lid te registreren in het systeem.
        </p>
    </div>
</section>

<section class="nieuwlid-formulier-sectie">
    <div class="container">
        <div class="nieuwlid-formulier-box">

            <?php if ($succesmelding !== ''): ?>
                <div class="nieuwlid-melding nieuwlid-melding--succes">
                    <?php echo htmlspecialchars($succesmelding); ?>
                </div>
            <?php endif; ?>

            <?php if ($foutmelding !== ''): ?>
                <div class="nieuwlid-melding nieuwlid-melding--fout">
                    <?php echo htmlspecialchars($foutmelding); ?>
                </div>
            <?php endif; ?>

            <form method="POST" action="" class="nieuwlid-formulier">
                <div class="nieuwlid-formulier-grid">
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
