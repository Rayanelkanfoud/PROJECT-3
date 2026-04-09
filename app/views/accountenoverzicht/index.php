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

        <?php if ($succesmelding !== ''): ?>
            <div class="account-melding account-melding--succes" style="margin-bottom:16px;">
                <?php echo htmlspecialchars($succesmelding); ?>
            </div>
        <?php endif; ?>
        <?php if ($foutmelding !== '' && $wijzigAccount === null): ?>
            <div class="account-melding account-melding--fout" style="margin-bottom:16px;">
                <?php echo htmlspecialchars($foutmelding); ?>
            </div>
        <?php endif; ?>

        <p class="accounts-hint">Klik met de rechtermuisknop op een rij om een account te wijzigen of verwijderen.</p>

        <div class="accounts-tabel-wrapper">
            <table class="accounts-tabel">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Naam</th>
                        <th>E-mailadres</th>
                        <th>Rol</th>
                        <th>Actief</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($accounts as $account): ?>
                        <tr class="account-rij" data-id="<?php echo $account['id']; ?>">
                            <td><?php echo $account['id']; ?></td>
                            <td><?php echo htmlspecialchars($account['volledige_naam']); ?></td>
                            <td><?php echo htmlspecialchars($account['email']); ?></td>
                            <td><?php echo htmlspecialchars($account['rol']); ?></td>
                            <td><?php echo $account['is_actief'] ? 'Ja' : 'Nee'; ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</section>

<!-- Context menu -->
<div id="account-context-menu" class="context-menu" style="display:none;">
    <ul>
        <li id="ctx-wijzig-account">✏️ Wijzigen</li>
        <li id="ctx-verwijder-account">🗑️ Verwijderen</li>
    </ul>
</div>

<!-- Verborgen forms voor context menu acties -->
<form id="laad-wijzig-account-form" method="POST" action="" style="display:none;">
    <input type="hidden" name="actie" value="laad_wijzig">
    <input type="hidden" name="account_id" id="laad-wijzig-account-id" value="">
</form>

<!-- Bevestigingsmodal voor verwijderen -->
<div id="verwijder-modal" class="modal-overlay" style="display:none;">
    <div class="modal-box">
        <h2>Account verwijderen</h2>
        <p>Weet je zeker dat je het account van <strong id="modal-naam"></strong> wilt verwijderen?</p>
        <div class="modal-knoppen">
            <form method="POST" action="">
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

<!-- Wijzig-modal -->
<?php if ($wijzigAccount !== null): ?>
<div id="wijzig-account-modal" class="modal-overlay">
<?php else: ?>
<div id="wijzig-account-modal" class="modal-overlay" style="display:none;">
<?php endif; ?>
    <div class="modal-box">
        <h2>Account wijzigen</h2>
        <?php if ($foutmelding !== '' && $wijzigAccount !== null): ?>
            <div class="account-melding account-melding--fout" style="margin-bottom:16px;">
                <?php echo htmlspecialchars($foutmelding); ?>
            </div>
        <?php endif; ?>
        <form method="POST" action="" class="account-formulier">
            <input type="hidden" name="actie" value="wijzig">
            <input type="hidden" name="account_id" value="<?php echo $wijzigAccount['id'] ?? ''; ?>">
            <div class="account-formulier-grid">
                <div class="formulier-groep">
                    <label>Rol *</label>
                    <select name="rol_id">
                        <option value="">Kies een rol</option>
                        <?php foreach ($rollen as $rol): ?>
                            <option value="<?php echo $rol['id']; ?>" <?php echo ($wijzigAccount['rol_id'] ?? '') == $rol['id'] ? 'selected' : ''; ?>>
                                <?php echo htmlspecialchars($rol['naam']); ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="formulier-groep">
                    <label>Voornaam *</label>
                    <input type="text" name="voornaam" value="<?php echo htmlspecialchars($wijzigAccount['voornaam'] ?? ''); ?>">
                </div>
                <div class="formulier-groep">
                    <label>Tussenvoegsel</label>
                    <input type="text" name="tussenvoegsel" value="<?php echo htmlspecialchars($wijzigAccount['tussenvoegsel'] ?? ''); ?>">
                </div>
                <div class="formulier-groep">
                    <label>Achternaam *</label>
                    <input type="text" name="achternaam" value="<?php echo htmlspecialchars($wijzigAccount['achternaam'] ?? ''); ?>">
                </div>
                <div class="formulier-groep">
                    <label>E-mailadres *</label>
                    <input type="email" name="email" value="<?php echo htmlspecialchars($wijzigAccount['email'] ?? ''); ?>">
                </div>
            </div>
            <div class="formulier-groep opmerking-groep">
                <label>Opmerking</label>
                <textarea name="opmerking" rows="3"><?php echo htmlspecialchars($wijzigAccount['opmerking'] ?? ''); ?></textarea>
            </div>
            <div class="modal-knoppen">
                <button type="submit" class="button-primary">Opslaan</button>
                <button type="button" class="button-annuleer" onclick="document.getElementById('wijzig-account-modal').style.display='none'">Annuleren</button>
            </div>
        </form>
    </div>
</div>

<script>
    const accountCtxMenu = document.getElementById('account-context-menu');
    let geselecteerdAccountId = null;

    document.querySelectorAll('.account-rij').forEach(function(rij) {
        rij.addEventListener('contextmenu', function(e) {
            e.preventDefault();
            geselecteerdAccountId = rij.getAttribute('data-id');
            accountCtxMenu.style.display = 'block';
            accountCtxMenu.style.left = e.pageX + 'px';
            accountCtxMenu.style.top  = e.pageY + 'px';
        });
    });

    document.getElementById('ctx-wijzig-account').addEventListener('click', function() {
        accountCtxMenu.style.display = 'none';
        if (geselecteerdAccountId) {
            document.getElementById('laad-wijzig-account-id').value = geselecteerdAccountId;
            document.getElementById('laad-wijzig-account-form').submit();
        }
    });

    document.getElementById('ctx-verwijder-account').addEventListener('click', function() {
        accountCtxMenu.style.display = 'none';
        if (geselecteerdAccountId) {
            document.getElementById('modal-verwijder-id').value = geselecteerdAccountId;
            document.getElementById('modal-naam').textContent = 'ID ' + geselecteerdAccountId;
            document.getElementById('verwijder-modal').style.display = 'flex';
        }
    });

    document.addEventListener('click', function() {
        accountCtxMenu.style.display = 'none';
    });
</script>

<!-- Hier accounts toevoegen -->
<section class="account-toevoegen">
    <div class="container">
        <div class="account-formulier-box">
            <h2>Nieuwe account toevoegen</h2>

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