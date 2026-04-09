<?php require_once __DIR__ . '/../../../includes/header.php'; ?>

<section class="lessen-hero">
    <div class="container">
        <p class="lessen-badge">Lessen overzicht</p>
        <h1>Bekijk en voeg lessen toe</h1>
        <p class="lessen-intro">
            Hieronder zie je alle lessen in het systeem en kun je direct een nieuwe les toevoegen.
        </p>
    </div>
</section>

<section class="lessen-overzicht">
    <div class="container">
        <h2 class="lessen-subtitel">Alle lessen in het systeem</h2>

        <?php if ($succesmelding !== ''): ?>
            <div class="les-melding les-melding--succes" style="margin-bottom:16px;">
                <?php echo htmlspecialchars($succesmelding); ?>
            </div>
        <?php endif; ?>
        <?php if ($foutmelding !== '' && $wijzigLes === null): ?>
            <div class="les-melding les-melding--fout" style="margin-bottom:16px;">
                <?php echo htmlspecialchars($foutmelding); ?>
            </div>
        <?php endif; ?>

        <!-- Zoeken op datum (US 84) -->
        <form method="GET" action="" class="les-zoek-form">
            <div class="les-zoek-groep">
                <label for="zoek_datum">Zoeken op datum:</label>
                <input type="date" id="zoek_datum" name="zoek_datum" value="<?php echo htmlspecialchars($zoekDatum); ?>">
                <button type="submit" class="button-primary">Zoeken</button>
                <?php if ($zoekDatum !== ''): ?>
                    <a href="lessen.php" class="button-annuleer" style="text-decoration:none; display:inline-block; padding:10px 22px;">Wis filter</a>
                <?php endif; ?>
            </div>
        </form>

        <?php if ($zoekDatum !== '' && $zoekResultaten !== null): ?>
            <?php if (empty($zoekResultaten)): ?>
                <div class="les-melding les-melding--fout" style="margin:16px 0;">
                    Er zijn geen lessen gevonden op deze datum.
                </div>
            <?php else: ?>
                <p style="margin-bottom:10px; color:#2c7a4b; font-weight:600;">
                    <?php echo count($zoekResultaten); ?> les(sen) gevonden op <?php echo htmlspecialchars($zoekDatum); ?>:
                </p>
            <?php endif; ?>
        <?php endif; ?>

        <p class="lessen-hint">Klik met de rechtermuisknop op een rij om een les te wijzigen of annuleren.</p>

        <div class="lessen-tabel-wrapper">
            <table class="lessen-tabel">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Naam</th>
                        <th>Prijs</th>
                        <th>Datum</th>
                        <th>Tijd</th>
                        <th>Min</th>
                        <th>Max</th>
                        <th>Status</th>
                        <th>Aanbieding</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $toonLessen = ($zoekDatum !== '' && $zoekResultaten !== null) ? $zoekResultaten : $lessen; ?>
                    <?php foreach ($toonLessen as $les): ?>
                        <tr class="les-rij" data-id="<?php echo $les['id']; ?>">
                            <td><?php echo $les['id']; ?></td>
                            <td><?php echo htmlspecialchars($les['naam']); ?></td>
                            <td>€<?php echo number_format($les['prijs'], 2, ',', '.'); ?></td>
                            <td><?php echo htmlspecialchars($les['datum']); ?></td>
                            <td><?php echo htmlspecialchars($les['tijd']); ?></td>
                            <td><?php echo htmlspecialchars($les['min_aantal_personen']); ?></td>
                            <td><?php echo htmlspecialchars($les['max_aantal_personen']); ?></td>
                            <td><?php echo htmlspecialchars($les['status']); ?></td>
                            <td><?php echo $les['is_aanbieding'] ? 'Ja' : 'Nee'; ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</section>

<!-- Context menu lessen -->
<div id="les-context-menu" class="context-menu" style="display:none;">
    <ul>
        <li id="ctx-les-wijzig">✏️ Wijzigen</li>
        <li id="ctx-les-annuleer">🚫 Annuleren</li>
    </ul>
</div>

<!-- Hidden form om les te laden voor wijzigen -->
<form id="laad-wijzig-les-form" method="POST" action="" style="display:none;">
    <input type="hidden" name="actie" value="laad_wijzig">
    <input type="hidden" name="les_id" id="laad-wijzig-les-id" value="">
</form>

<!-- Bevestigingsmodal les annuleren -->
<div id="annuleer-les-modal" class="modal-overlay" style="display:none;">
    <div class="modal-box">
        <h2>Les annuleren</h2>
        <p>Weet je zeker dat je deze les wilt annuleren? De status wordt gewijzigd naar "Geannuleerd".</p>
        <div class="modal-knoppen">
            <form method="POST" action="">
                <input type="hidden" name="actie" value="annuleer_les">
                <input type="hidden" name="les_id" id="annuleer-les-id" value="">
                <button type="submit" class="button-primary">Bevestigen</button>
            </form>
            <form method="POST" action="">
                <input type="hidden" name="actie" value="annuleer_annuleren">
                <button type="submit" class="button-annuleer">Annuleren</button>
            </form>
        </div>
    </div>
</div>

<!-- Wijzig-modal les -->
<?php if ($wijzigLes !== null): ?>
<div id="wijzig-les-modal" class="modal-overlay">
<?php else: ?>
<div id="wijzig-les-modal" class="modal-overlay" style="display:none;">
<?php endif; ?>
    <div class="modal-box">
        <h2>Les wijzigen</h2>
        <?php if ($foutmelding !== '' && $wijzigLes !== null): ?>
            <div class="les-melding les-melding--fout" style="margin-bottom:16px;">
                <?php echo htmlspecialchars($foutmelding); ?>
            </div>
        <?php endif; ?>
        <form method="POST" action="" class="les-formulier">
            <input type="hidden" name="actie" value="wijzig">
            <input type="hidden" name="les_id" value="<?php echo $wijzigLes['id'] ?? ''; ?>">
            <div class="les-formulier-grid">
                <div class="formulier-groep">
                    <label>Naam *</label>
                    <input type="text" name="naam" value="<?php echo htmlspecialchars($wijzigLes['naam'] ?? ''); ?>">
                </div>
                <div class="formulier-groep">
                    <label>Prijs *</label>
                    <input type="number" step="0.01" name="prijs" value="<?php echo htmlspecialchars($wijzigLes['prijs'] ?? ''); ?>">
                </div>
                <div class="formulier-groep">
                    <label>Datum *</label>
                    <input type="date" name="datum" value="<?php echo htmlspecialchars($wijzigLes['datum'] ?? ''); ?>">
                </div>
                <div class="formulier-groep">
                    <label>Tijd *</label>
                    <input type="time" name="tijd" value="<?php echo htmlspecialchars($wijzigLes['tijd'] ?? ''); ?>">
                </div>
                <div class="formulier-groep">
                    <label>Min. personen *</label>
                    <input type="number" name="min_aantal_personen" value="<?php echo htmlspecialchars($wijzigLes['min_aantal_personen'] ?? ''); ?>">
                </div>
                <div class="formulier-groep">
                    <label>Max. personen *</label>
                    <input type="number" name="max_aantal_personen" value="<?php echo htmlspecialchars($wijzigLes['max_aantal_personen'] ?? ''); ?>">
                </div>
                <div class="formulier-groep">
                    <label>Status *</label>
                    <select name="status">
                        <option value="">Kies een status</option>
                        <?php foreach (['Gepland','Niet gestart','Gestart','Geannuleerd'] as $s): ?>
                            <option value="<?php echo $s; ?>" <?php echo ($wijzigLes['status'] ?? '') === $s ? 'selected' : ''; ?>><?php echo $s; ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="formulier-groep checkbox-groep">
                    <label>Aanbieding</label>
                    <input type="checkbox" name="is_aanbieding" <?php echo ($wijzigLes['is_aanbieding'] ?? 0) ? 'checked' : ''; ?>>
                </div>
            </div>
            <div class="formulier-groep opmerking-groep">
                <label>Opmerking</label>
                <textarea name="opmerking" rows="3"><?php echo htmlspecialchars($wijzigLes['opmerking'] ?? ''); ?></textarea>
            </div>
            <div class="modal-knoppen">
                <button type="submit" class="button-primary">Opslaan</button>
                <button type="button" class="button-annuleer" onclick="document.getElementById('wijzig-les-modal').style.display='none'">Annuleren</button>
            </div>
        </form>
    </div>
</div>

<script>
    const lesCtxMenu = document.getElementById('les-context-menu');
    let geselecteerdLesId = null;

    document.querySelectorAll('.les-rij').forEach(function(rij) {
        rij.addEventListener('contextmenu', function(e) {
            e.preventDefault();
            geselecteerdLesId = rij.getAttribute('data-id');
            lesCtxMenu.style.display = 'block';
            lesCtxMenu.style.left = e.pageX + 'px';
            lesCtxMenu.style.top  = e.pageY + 'px';
        });
    });

    document.getElementById('ctx-les-wijzig').addEventListener('click', function() {
        lesCtxMenu.style.display = 'none';
        if (geselecteerdLesId) {
            document.getElementById('laad-wijzig-les-id').value = geselecteerdLesId;
            document.getElementById('laad-wijzig-les-form').submit();
        }
    });

    document.getElementById('ctx-les-annuleer').addEventListener('click', function() {
        lesCtxMenu.style.display = 'none';
        if (geselecteerdLesId) {
            document.getElementById('annuleer-les-id').value = geselecteerdLesId;
            document.getElementById('annuleer-les-modal').style.display = 'flex';
        }
    });

    document.addEventListener('click', function() {
        lesCtxMenu.style.display = 'none';
    });
</script>

<!-- Hier heb je het formulier -->
<section class="les-toevoegen">
    <div class="container">
        <div class="les-formulier-box">
            <h2>Nieuwe les maken</h2>

            <form method="POST" action="" class="les-formulier">
                <div class="les-formulier-grid">
                    <div class="formulier-groep">
                        <label for="naam">Naam</label>
                        <input type="text" id="naam" name="naam" value="<?php echo htmlspecialchars($naam); ?>">
                    </div>
                    <div class="formulier-groep">
                        <label for="prijs">Prijs</label>
                        <input type="number" step="0.01" id="prijs" name="prijs" value="<?php echo htmlspecialchars($prijs); ?>">
                    </div>
                    <div class="formulier-groep">
                        <label for="datum">Datum</label>
                        <input type="date" id="datum" name="datum" value="<?php echo htmlspecialchars($datum); ?>">
                    </div>
                    <div class="formulier-groep">
                        <label for="tijd">Tijd</label>
                        <input type="time" id="tijd" name="tijd" value="<?php echo htmlspecialchars($tijd); ?>">
                    </div>
                    <div class="formulier-groep">
                        <label for="min_aantal_personen">Minimaal aantal personen</label>
                        <input type="number" id="min_aantal_personen" name="min_aantal_personen" value="<?php echo htmlspecialchars($minAantalPersonen); ?>">
                    </div>
                    <div class="formulier-groep">
                        <label for="max_aantal_personen">Maximaal aantal personen</label>
                        <input type="number" id="max_aantal_personen" name="max_aantal_personen" value="<?php echo htmlspecialchars($maxAantalPersonen); ?>">
                    </div>
                    <div class="formulier-groep">
                        <label for="status">Status</label>
                        <select id="status" name="status">
                            <option value="">Kies een status</option>
                            <option value="Gepland" <?php echo $status === 'Gepland' ? 'selected' : ''; ?>>Gepland</option>
                            <option value="Niet gestart" <?php echo $status === 'Niet gestart' ? 'selected' : ''; ?>>Niet gestart</option>
                            <option value="Gestart" <?php echo $status === 'Gestart' ? 'selected' : ''; ?>>Gestart</option>
                            <option value="Geannuleerd" <?php echo $status === 'Geannuleerd' ? 'selected' : ''; ?>>Geannuleerd</option>
                        </select>
                    </div>
                    <div class="formulier-groep checkbox-groep">
                        <label for="is_aanbieding">Aanbieding</label>
                        <input type="checkbox" id="is_aanbieding" name="is_aanbieding" <?php echo $isAanbieding ? 'checked' : ''; ?>>
                    </div>
                </div>
                <div class="formulier-groep opmerking-groep">
                    <label for="opmerking">Opmerking</label>
                    <textarea id="opmerking" name="opmerking" rows="4"><?php echo htmlspecialchars($opmerking); ?></textarea>
                </div>
                <button type="submit" class="button-primary">Opslaan</button>
            </form>
        </div>
    </div>
</section>

<?php require_once __DIR__ . '/../../../includes/footer.php'; ?>
