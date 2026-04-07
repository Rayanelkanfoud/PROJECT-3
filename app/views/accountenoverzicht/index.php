<?php require_once __DIR__ . '/../../../includes/header.php'; ?>

<section class="accounts-hero">
    <div class="container">
        <p class="accounts-badge">Accounts overzicht</p>
        <h1>Bekijk en voeg accounts toe</h1>
        <p class="accounts-intro">
            Hieronder zie je alle accounts in het systeem en kun je direct een nieuw account toevoegen.
        </p>
    </div>
</section>

<!-- Hier zie je een overzicht van de aangemaakt accounten -->
<section class="accounts-overzicht">
    <div class="container">
        <h2 class="accounts-subtitel">Alle accounts in het systeem</h2>

        <div class="accounts-tabel-wrapper">
            <table class="accounts-tabel">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Naam</th>
                        <th>E-mailadres</th>
                        <th>Rol</th>
                        <th>Actief</th>
                        <th>Acties</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($accounts as $account): ?>
                        <tr>
                            <td><?php echo $account['id']; ?></td>
                            <td><?php echo htmlspecialchars($account['volledige_naam']); ?></td>
                            <td><?php echo htmlspecialchars($account['email']); ?></td>
                            <td><?php echo htmlspecialchars($account['rol']); ?></td>
                            <td><?php echo $account['is_actief'] ? 'Ja' : 'Nee'; ?></td>
                            <td>
                                <button
                                    type="button"
                                    class="button-verwijder"
                                    onclick="openVerwijderModal(<?php echo $account['id']; ?>, '<?php echo htmlspecialchars(addslashes($account['volledige_naam'])); ?>')"
                                >
                                    Verwijderen
                                </button>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>

        <!-- Bevestigingsmodal voor verwijderen -->
        <div id="verwijder-modal" class="modal-overlay" style="display:none;">
            <div class="modal-box">
                <h2>Account verwijderen</h2>
                <p>Weet je zeker dat je het account van <strong id="modal-naam"></strong> wilt verwijderen?</p>
                <div class="modal-knoppen">
                    <form method="POST" action="" id="bevestig-form">
                        <input type="hidden" name="actie" value="verwijder">
                        <input type="hidden" name="verwijder_id" id="modal-verwijder-id" value="">
                        <button type="submit" class="button-primary">Bevestigen</button>
                    </form>
                    <form method="POST" action="">
                        <input type="hidden" name="actie" value="annuleer">
                        <button type="submit" class="button-annuleer">Annuleren</button>
                    </form>
                </div>
            </div>
        </div>

        <script>
            function openVerwijderModal(id, naam) {
                document.getElementById('modal-naam').textContent = naam;
                document.getElementById('modal-verwijder-id').value = id;
                document.getElementById('verwijder-modal').style.display = 'flex';
            }
        </script>
    </div>
</section>
<!-- Hier accounts toevoegen -->
<section class="account-toevoegen">
    <div class="container">
        <div class="account-formulier-box">
            <h2>Nieuwe account toevoegen</h2>
<!-- Javascript voor het formulier -->
            <?php if ($succesmelding !== ''): ?>
                <div class="account-melding account-melding--succes">
                    <?php echo htmlspecialchars($succesmelding); ?>
                </div>
            <?php endif; ?>

            <?php if ($foutmelding !== ''): ?>
                <div class="account-melding account-melding--fout">
                    <?php echo htmlspecialchars($foutmelding); ?>
                </div>
            <?php endif; ?>

            <form method="POST" action="" class="account-formulier">
                <div class="account-formulier-grid">
                    <div class="formulier-groep">
                        <label for="rol_id">Rol</label>
                        <select id="rol_id" name="rol_id">
                            <option value="">Kies een rol</option>
                            <?php foreach ($rollen as $rol): ?>
                                <option value="<?php echo $rol['id']; ?>" <?php echo $rolId == $rol['id'] ? 'selected' : ''; ?>>
                                    <?php echo htmlspecialchars($rol['naam']); ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
<!-- Formulier velden -->
                    <div class="formulier-groep">
                        <label for="voornaam">Voornaam</label>
                        <input type="text" id="voornaam" name="voornaam" value="<?php echo htmlspecialchars($voornaam); ?>">
                    </div>

                    <div class="formulier-groep">
                        <label for="tussenvoegsel">Tussenvoegsel</label>
                        <input type="text" id="tussenvoegsel" name="tussenvoegsel" value="<?php echo htmlspecialchars($tussenvoegsel); ?>">
                    </div>

                    <div class="formulier-groep">
                        <label for="achternaam">Achternaam</label>
                        <input type="text" id="achternaam" name="achternaam" value="<?php echo htmlspecialchars($achternaam); ?>">
                    </div>

                    <div class="formulier-groep">
                        <label for="email">E-mailadres</label>
                        <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($email); ?>">
                    </div>

                    <div class="formulier-groep">
                        <label for="wachtwoord">Wachtwoord</label>
                        <input type="text" id="wachtwoord" name="wachtwoord" value="<?php echo htmlspecialchars($wachtwoord); ?>">
                    </div>
                </div>

                <div class="formulier-groep opmerking-groep">
                    <label for="opmerking">Opmerking</label>
                    <textarea id="opmerking" name="opmerking" rows="4"><?php echo htmlspecialchars($opmerking); ?></textarea>
                </div>
<!-- Hier heb je de knop -->
                <button type="submit" class="button-primary">Opslaan</button>
            </form>
        </div>
    </div>
</section>

<?php require_once __DIR__ . '/../../../includes/footer.php'; ?>