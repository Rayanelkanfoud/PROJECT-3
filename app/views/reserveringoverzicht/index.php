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

        <?php if ($succesmelding !== ''): ?>
            <div class="reservering-melding reservering-melding--succes" style="margin-bottom:16px;">
                <?php echo htmlspecialchars($succesmelding); ?>
            </div>
        <?php endif; ?>
        <?php if ($foutmelding !== '' && $wijzigReservering === null): ?>
            <div class="reservering-melding reservering-melding--fout" style="margin-bottom:16px;">
                <?php echo htmlspecialchars($foutmelding); ?>
            </div>
        <?php endif; ?>

        <p class="reserveringen-hint">Klik met de rechtermuisknop op een rij om een reservering te wijzigen of verwijderen.</p>

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
                            <tr class="reservering-rij" data-id="<?php echo $reservering['id']; ?>">
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

<!-- Overzicht reserveringen per periode (US 331) -->
<section class="reserveringen-periode">
    <div class="container">
        <div class="reservering-formulier-box">
            <h2>Overzicht reserveringen per periode</h2>
            <form method="POST" action="" class="reservering-formulier">
                <input type="hidden" name="actie" value="periode_zoeken">
                <div class="reservering-formulier-grid">
                    <div>
                        <label for="van_datum">Van datum *</label>
                        <input type="date" id="van_datum" name="van_datum" value="<?php echo htmlspecialchars($vanDatum); ?>">
                    </div>
                    <div>
                        <label for="tot_datum">Tot datum *</label>
                        <input type="date" id="tot_datum" name="tot_datum" value="<?php echo htmlspecialchars($totDatum); ?>">
                    </div>
                </div>
                <button type="submit" class="button-primary" style="margin-top:16px;">Zoeken</button>
            </form>

            <?php if ($periodeResultaten !== null): ?>
                <?php if (empty($periodeResultaten)): ?>
                    <div class="reservering-melding reservering-melding--fout" style="margin-top:16px;">
                        Er zijn geen reserveringen gevonden in deze periode.
                    </div>
                <?php else: ?>
                    <table class="reserveringen-tabel" style="margin-top:20px;">
                        <thead>
                            <tr><th>Datum</th><th>Aantal reserveringen</th></tr>
                        </thead>
                        <tbody>
                            <?php foreach ($periodeResultaten as $rij): ?>
                                <tr>
                                    <td><?php echo htmlspecialchars($rij['datum']); ?></td>
                                    <td><?php echo $rij['aantal']; ?></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                <?php endif; ?>
            <?php endif; ?>
        </div>
    </div>
</section>

<!-- Nieuwe reservering toevoegen -->
<section class="reservering-toevoegen">
    <div class="container">
        <div class="reservering-formulier-box">
            <h2>Nieuwe reservering toevoegen</h2>

            <form method="POST" action="" class="reservering-formulier">
                <div class="reservering-formulier-grid">
                    <div>
                        <label for="lid_id">Lid *</label>
                        <select id="lid_id" name="lid_id">
                            <option value="">Kies een lid</option>
                            <?php foreach ($leden as $lid): ?>
                                <option value="<?php echo $lid['id']; ?>" <?php echo $lidId == $lid['id'] ? 'selected' : ''; ?>>
                                    <?php echo htmlspecialchars($lid['volledige_naam']); ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div>
                        <label for="les_id">Les *</label>
                        <select id="les_id" name="les_id">
                            <option value="">Kies een les</option>
                            <?php foreach ($lessen as $les): ?>
                                <option value="<?php echo $les['id']; ?>" <?php echo $lesId == $les['id'] ? 'selected' : ''; ?>>
                                    <?php echo htmlspecialchars($les['naam'] . ' — ' . $les['datum'] . ' ' . $les['tijd']); ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>
                <button type="submit" class="button-primary">Opslaan</button>
            </form>
        </div>
    </div>
</section>

<!-- Context menu -->
<div id="reservering-context-menu" class="context-menu" style="display:none;">
    <ul>
        <li id="ctx-reservering-wijzig">✏️ Wijzigen</li>
        <li id="ctx-reservering-verwijder">🗑️ Verwijderen</li>
    </ul>
</div>

<!-- Hidden form voor laad_wijzig -->
<form id="laad-wijzig-reservering-form" method="POST" action="" style="display:none;">
    <input type="hidden" name="actie" value="laad_wijzig">
    <input type="hidden" name="reservering_id" id="laad-wijzig-reservering-id" value="">
</form>

<!-- Bevestigingsmodal verwijderen -->
<div id="verwijder-reservering-modal" class="modal-overlay" style="display:none;">
    <div class="modal-box">
        <h2>Reservering verwijderen</h2>
        <p>Weet je zeker dat je deze reservering wilt verwijderen?</p>
        <div class="modal-knoppen">
            <form method="POST" action="">
                <input type="hidden" name="actie" value="verwijder">
                <input type="hidden" name="verwijder_id" id="verwijder-reservering-id" value="">
                <button type="submit" class="button-primary">Bevestigen</button>
            </form>
            <form method="POST" action="">
                <input type="hidden" name="actie" value="annuleer_verwijder">
                <button type="submit" class="button-annuleer">Annuleren</button>
            </form>
        </div>
    </div>
</div>

<!-- Wijzig-modal reservering -->
<?php if ($wijzigReservering !== null): ?>
<div id="wijzig-reservering-modal" class="modal-overlay">
<?php else: ?>
<div id="wijzig-reservering-modal" class="modal-overlay" style="display:none;">
<?php endif; ?>
    <div class="modal-box">
        <h2>Reservering wijzigen</h2>
        <?php if ($foutmelding !== '' && $wijzigReservering !== null): ?>
            <div class="reservering-melding reservering-melding--fout" style="margin-bottom:16px;">
                <?php echo htmlspecialchars($foutmelding); ?>
            </div>
        <?php endif; ?>
        <form method="POST" action="" class="reservering-formulier">
            <input type="hidden" name="actie" value="wijzig">
            <input type="hidden" name="reservering_id" value="<?php echo $wijzigReservering['id'] ?? ''; ?>">
            <div class="reservering-formulier-grid">
                <div>
                    <label>Lid *</label>
                    <select name="lid_id">
                        <option value="">Kies een lid</option>
                        <?php foreach ($leden as $lid): ?>
                            <option value="<?php echo $lid['id']; ?>" <?php echo ($wijzigReservering['lid_id'] ?? '') == $lid['id'] ? 'selected' : ''; ?>>
                                <?php echo htmlspecialchars($lid['volledige_naam']); ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div>
                    <label>Les *</label>
                    <select name="les_id">
                        <option value="">Kies een les</option>
                        <?php foreach ($lessen as $les): ?>
                            <option value="<?php echo $les['id']; ?>" <?php echo ($wijzigReservering['les_id'] ?? '') == $les['id'] ? 'selected' : ''; ?>>
                                <?php echo htmlspecialchars($les['naam'] . ' — ' . $les['datum'] . ' ' . $les['tijd']); ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div>
                    <label>Status *</label>
                    <select name="reserveringsstatus">
                        <?php foreach (['actief','geannuleerd','voltooid'] as $s): ?>
                            <option value="<?php echo $s; ?>" <?php echo ($wijzigReservering['reserveringsstatus'] ?? '') === $s ? 'selected' : ''; ?>><?php echo ucfirst($s); ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>
            <div class="modal-knoppen">
                <button type="submit" class="button-primary">Opslaan</button>
                <button type="button" class="button-annuleer" onclick="document.getElementById('wijzig-reservering-modal').style.display='none'">Annuleren</button>
            </div>
        </form>
    </div>
</div>

<script>
    const resvCtxMenu = document.getElementById('reservering-context-menu');
    let geselecteerdReserveringId = null;

    document.querySelectorAll('.reservering-rij').forEach(function(rij) {
        rij.addEventListener('contextmenu', function(e) {
            e.preventDefault();
            geselecteerdReserveringId = rij.getAttribute('data-id');
            resvCtxMenu.style.display = 'block';
            resvCtxMenu.style.left = e.pageX + 'px';
            resvCtxMenu.style.top  = e.pageY + 'px';
        });
    });

    document.getElementById('ctx-reservering-wijzig').addEventListener('click', function() {
        resvCtxMenu.style.display = 'none';
        if (geselecteerdReserveringId) {
            document.getElementById('laad-wijzig-reservering-id').value = geselecteerdReserveringId;
            document.getElementById('laad-wijzig-reservering-form').submit();
        }
    });

    document.getElementById('ctx-reservering-verwijder').addEventListener('click', function() {
        resvCtxMenu.style.display = 'none';
        if (geselecteerdReserveringId) {
            document.getElementById('verwijder-reservering-id').value = geselecteerdReserveringId;
            document.getElementById('verwijder-reservering-modal').style.display = 'flex';
        }
    });

    document.addEventListener('click', function() {
        resvCtxMenu.style.display = 'none';
    });
</script>

<?php require_once __DIR__ . '/../../../includes/footer.php'; ?>
