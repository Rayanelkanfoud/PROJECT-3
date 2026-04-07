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

        <?php if ($succesmelding !== ''): ?>
            <div class="lid-melding lid-melding--succes" style="margin-bottom:16px;">
                <?php echo htmlspecialchars($succesmelding); ?>
            </div>
        <?php endif; ?>
        <?php if ($foutmelding !== '' && $wijzigLid === null): ?>
            <div class="lid-melding lid-melding--fout" style="margin-bottom:16px;">
                <?php echo htmlspecialchars($foutmelding); ?>
            </div>
        <?php endif; ?>

        <p class="leden-hint">Klik met de rechtermuisknop op een rij om een lid te wijzigen of verwijderen.</p>

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
                    <?php foreach ($leden as $lid): ?>
                        <tr class="lid-rij" data-id="<?php echo $lid['id']; ?>">
                            <td><?php echo $lid['id']; ?></td>
                            <td><?php echo htmlspecialchars($lid['volledige_naam']); ?></td>
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
</section>

<!-- Context menu -->
<div id="lid-context-menu" class="context-menu" style="display:none;">
    <ul>
        <li id="ctx-lid-wijzig">✏️ Wijzigen</li>
        <li id="ctx-lid-verwijder">🗑️ Verwijderen</li>
    </ul>
</div>

<!-- Hidden form om lid te laden voor wijzigen -->
<form id="laad-wijzig-lid-form" method="POST" action="" style="display:none;">
    <input type="hidden" name="actie" value="laad_wijzig">
    <input type="hidden" name="lid_id" id="laad-wijzig-lid-id" value="">
</form>

<!-- Bevestigingsmodal verwijderen lid -->
<div id="verwijder-lid-modal" class="modal-overlay" style="display:none;">
    <div class="modal-box">
        <h2>Lid verwijderen</h2>
        <p>Weet je zeker dat je dit lid wilt verwijderen?</p>
        <div class="modal-knoppen">
            <form method="POST" action="">
                <input type="hidden" name="actie" value="verwijder">
                <input type="hidden" name="verwijder_id" id="verwijder-lid-id" value="">
                <button type="submit" class="button-primary">Bevestigen</button>
            </form>
            <form method="POST" action="">
                <input type="hidden" name="actie" value="annuleer_verwijder">
                <button type="submit" class="button-annuleer">Annuleren</button>
            </form>
        </div>
    </div>
</div>

<!-- Wijzig-modal lid -->
<?php if ($wijzigLid !== null): ?>
<div id="wijzig-lid-modal" class="modal-overlay">
<?php else: ?>
<div id="wijzig-lid-modal" class="modal-overlay" style="display:none;">
<?php endif; ?>
    <div class="modal-box">
        <h2>Lid wijzigen</h2>
        <?php if ($foutmelding !== '' && $wijzigLid !== null): ?>
            <div class="lid-melding lid-melding--fout" style="margin-bottom:16px;">
                <?php echo htmlspecialchars($foutmelding); ?>
            </div>
        <?php endif; ?>
        <form method="POST" action="">
            <input type="hidden" name="actie" value="wijzig">
            <input type="hidden" name="lid_id" value="<?php echo $wijzigLid['id'] ?? ''; ?>">
            <div class="lid-formulier-grid">
                <div>
                    <label>Voornaam *</label>
                    <input type="text" name="voornaam" value="<?php echo htmlspecialchars($wijzigLid['voornaam'] ?? ''); ?>">
                </div>
                <div>
                    <label>Tussenvoegsel</label>
                    <input type="text" name="tussenvoegsel" value="<?php echo htmlspecialchars($wijzigLid['tussenvoegsel'] ?? ''); ?>">
                </div>
                <div>
                    <label>Achternaam *</label>
                    <input type="text" name="achternaam" value="<?php echo htmlspecialchars($wijzigLid['achternaam'] ?? ''); ?>">
                </div>
                <div>
                    <label>E-mailadres *</label>
                    <input type="email" name="email" value="<?php echo htmlspecialchars($wijzigLid['email'] ?? ''); ?>">
                </div>
                <div>
                    <label>Mobiel</label>
                    <input type="text" name="mobiel" value="<?php echo htmlspecialchars($wijzigLid['mobiel'] ?? ''); ?>">
                </div>
                <div>
                    <label>Relatienummer</label>
                    <input type="text" name="relatienummer" value="<?php echo htmlspecialchars($wijzigLid['relatienummer'] ?? ''); ?>">
                </div>
            </div>
            <div class="modal-knoppen">
                <button type="submit" class="button-primary">Opslaan</button>
                <button type="button" class="button-annuleer" onclick="document.getElementById('wijzig-lid-modal').style.display='none'">Annuleren</button>
            </div>
        </form>
    </div>
</div>

<script>
    const lidCtxMenu = document.getElementById('lid-context-menu');
    let geselecteerdLidId = null;

    document.querySelectorAll('.lid-rij').forEach(function(rij) {
        rij.addEventListener('contextmenu', function(e) {
            e.preventDefault();
            geselecteerdLidId = rij.getAttribute('data-id');
            lidCtxMenu.style.display = 'block';
            lidCtxMenu.style.left = e.pageX + 'px';
            lidCtxMenu.style.top  = e.pageY + 'px';
        });
    });

    document.getElementById('ctx-lid-wijzig').addEventListener('click', function() {
        lidCtxMenu.style.display = 'none';
        if (geselecteerdLidId) {
            document.getElementById('laad-wijzig-lid-id').value = geselecteerdLidId;
            document.getElementById('laad-wijzig-lid-form').submit();
        }
    });

    document.getElementById('ctx-lid-verwijder').addEventListener('click', function() {
        lidCtxMenu.style.display = 'none';
        if (geselecteerdLidId) {
            document.getElementById('verwijder-lid-id').value = geselecteerdLidId;
            document.getElementById('verwijder-lid-modal').style.display = 'flex';
        }
    });

    document.addEventListener('click', function() {
        lidCtxMenu.style.display = 'none';
    });
</script>

<?php require_once __DIR__ . '/../../../includes/footer.php'; ?>
