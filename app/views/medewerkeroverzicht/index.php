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

        <?php if ($succesmelding !== ''): ?>
            <div class="medewerker-melding medewerker-melding--succes" style="margin-bottom:20px;">
                <?php echo htmlspecialchars($succesmelding); ?>
            </div>
        <?php endif; ?>

        <?php if ($foutmelding !== '' && $wijzigMedewerker === null): ?>
            <div class="medewerker-melding medewerker-melding--fout" style="margin-bottom:20px;">
                <?php echo htmlspecialchars($foutmelding); ?>
            </div>
        <?php endif; ?>

        <p class="medewerkers-hint">Klik met de rechtermuisknop op een rij om een medewerker te wijzigen.</p>

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
                            <tr class="medewerker-rij" data-id="<?php echo $medewerker['id']; ?>">
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

<!-- Context menu -->
<div id="context-menu" class="context-menu" style="display:none;">
    <ul>
        <li id="context-wijzig">✏️ Wijzigen</li>
    </ul>
</div>

<!-- Verborgen form om medewerkergegevens te laden (context menu actie) -->
<form id="laad-wijzig-form" method="POST" action="" style="display:none;">
    <input type="hidden" name="actie" value="laad_wijzig">
    <input type="hidden" name="medewerker_id" id="laad-wijzig-id" value="">
</form>

<!-- Wijzig-modal -->
<?php if ($wijzigMedewerker !== null): ?>
<div id="wijzig-modal" class="modal-overlay">
<?php else: ?>
<div id="wijzig-modal" class="modal-overlay" style="display:none;">
<?php endif; ?>
    <div class="modal-box">
        <h2>Medewerker wijzigen</h2>

        <?php if ($foutmelding !== '' && $wijzigMedewerker !== null): ?>
            <div class="medewerker-melding medewerker-melding--fout" style="margin-bottom:16px;">
                <?php echo htmlspecialchars($foutmelding); ?>
            </div>
        <?php endif; ?>

        <form method="POST" action="" class="medewerker-formulier">
            <input type="hidden" name="actie" value="wijzig">
            <input type="hidden" name="medewerker_id" value="<?php echo $wijzigMedewerker['id'] ?? ''; ?>">

            <div class="medewerker-formulier-grid">
                <div>
                    <label for="wijzig-voornaam">Voornaam *</label>
                    <input type="text" id="wijzig-voornaam" name="voornaam"
                           value="<?php echo htmlspecialchars($wijzigMedewerker['voornaam'] ?? ''); ?>">
                </div>
                <div>
                    <label for="wijzig-tussenvoegsel">Tussenvoegsel</label>
                    <input type="text" id="wijzig-tussenvoegsel" name="tussenvoegsel"
                           value="<?php echo htmlspecialchars($wijzigMedewerker['tussenvoegsel'] ?? ''); ?>">
                </div>
                <div>
                    <label for="wijzig-achternaam">Achternaam *</label>
                    <input type="text" id="wijzig-achternaam" name="achternaam"
                           value="<?php echo htmlspecialchars($wijzigMedewerker['achternaam'] ?? ''); ?>">
                </div>
                <div>
                    <label for="wijzig-email">E-mailadres *</label>
                    <input type="email" id="wijzig-email" name="email"
                           value="<?php echo htmlspecialchars($wijzigMedewerker['email'] ?? ''); ?>">
                </div>
                <div>
                    <label for="wijzig-medewerkersoort">Functie *</label>
                    <input type="text" id="wijzig-medewerkersoort" name="medewerkersoort"
                           value="<?php echo htmlspecialchars($wijzigMedewerker['medewerkersoort'] ?? ''); ?>">
                </div>
                <div>
                    <label for="wijzig-telefoonnummer">Telefoonnummer</label>
                    <input type="text" id="wijzig-telefoonnummer" name="telefoonnummer"
                           value="<?php echo htmlspecialchars($wijzigMedewerker['telefoonnummer'] ?? ''); ?>">
                </div>
            </div>

            <div class="modal-knoppen">
                <button type="submit" class="button-primary">Opslaan</button>
                <button type="button" class="button-annuleer" onclick="document.getElementById('wijzig-modal').style.display='none'">Annuleren</button>
            </div>
        </form>
    </div>
</div>

<script>
    const contextMenu = document.getElementById('context-menu');
    let geselecteerdeRijId = null;

    // Rechtermuisknop op een medewerker-rij
    document.querySelectorAll('.medewerker-rij').forEach(function(rij) {
        rij.addEventListener('contextmenu', function(e) {
            e.preventDefault();
            geselecteerdeRijId = rij.getAttribute('data-id');
            contextMenu.style.display = 'block';
            contextMenu.style.left = e.pageX + 'px';
            contextMenu.style.top  = e.pageY + 'px';
        });
    });

    // Klik op "Wijzigen" in context menu
    document.getElementById('context-wijzig').addEventListener('click', function() {
        contextMenu.style.display = 'none';
        if (geselecteerdeRijId) {
            document.getElementById('laad-wijzig-id').value = geselecteerdeRijId;
            document.getElementById('laad-wijzig-form').submit();
        }
    });

    // Context menu sluiten bij klik ergens anders
    document.addEventListener('click', function() {
        contextMenu.style.display = 'none';
    });
</script>

<section class="medewerker-toevoegen">
    <div class="container">
        <div class="medewerker-formulier-box">
            <h2>Nieuwe medewerker toevoegen</h2>

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