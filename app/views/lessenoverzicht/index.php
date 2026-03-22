<?php require_once __DIR__ . '/../../../includes/header.php'; ?>

<section class="lessen-hero">
    <div class="container">


    </div>
</section>

<section class="lessen-overzicht">
    <div class="container">
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
                    <?php foreach ($lessen as $les): ?>
                        <tr>
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

<section class="les-toevoegen">
    <div class="container">
        <div class="les-formulier-box">
            <h2>Nieuwe les maken</h2>

            <?php if ($succesmelding !== ''): ?>
                <div class="les-melding les-melding--succes">
                    <?php echo htmlspecialchars($succesmelding); ?>
                </div>
            <?php endif; ?>

            <?php if ($foutmelding !== ''): ?>
                <div class="les-melding les-melding--fout">
                    <?php echo htmlspecialchars($foutmelding); ?>
                </div>
            <?php endif; ?>

            <form method="POST" action="" class="les-formulier">
                <div class="les-formulier-grid">
                    <div>
                        <label for="naam">Naam</label>
                        <input type="text" id="naam" name="naam" value="<?php echo htmlspecialchars($naam); ?>">
                    </div>

                    <div>
                        <label for="prijs">Prijs</label>
                        <input type="number" step="0.01" id="prijs" name="prijs" value="<?php echo htmlspecialchars($prijs); ?>">
                    </div>

                    <div>
                        <label for="datum">Datum</label>
                        <input type="date" id="datum" name="datum" value="<?php echo htmlspecialchars($datum); ?>">
                    </div>

                    <div>
                        <label for="tijd">Tijd</label>
                        <input type="time" id="tijd" name="tijd" value="<?php echo htmlspecialchars($tijd); ?>">
                    </div>

                    <div>
                        <label for="min_aantal_personen">Minimaal aantal personen</label>
                        <input type="number" id="min_aantal_personen" name="min_aantal_personen" value="<?php echo htmlspecialchars($minAantalPersonen); ?>">
                    </div>

                    <div>
                        <label for="max_aantal_personen">Maximaal aantal personen</label>
                        <input type="number" id="max_aantal_personen" name="max_aantal_personen" value="<?php echo htmlspecialchars($maxAantalPersonen); ?>">
                    </div>

                    <div>
                        <label for="status">Status</label>
                        <select id="status" name="status">
                            <option value="">Kies een status</option>
                            <option value="Gepland" <?php echo $status === 'Gepland' ? 'selected' : ''; ?>>Gepland</option>
                            <option value="Niet gestart" <?php echo $status === 'Niet gestart' ? 'selected' : ''; ?>>Niet gestart</option>
                            <option value="Gestart" <?php echo $status === 'Gestart' ? 'selected' : ''; ?>>Gestart</option>
                            <option value="Geannuleerd" <?php echo $status === 'Geannuleerd' ? 'selected' : ''; ?>>Geannuleerd</option>
                        </select>
                    </div>

                    <div class="checkbox-vak">
                        <label for="is_aanbieding">Aanbieding</label>
                        <input type="checkbox" id="is_aanbieding" name="is_aanbieding" <?php echo $isAanbieding ? 'checked' : ''; ?>>
                    </div>
                </div>

                <div class="opmerking-vak">
                    <label for="opmerking">Opmerking</label>
                    <textarea id="opmerking" name="opmerking" rows="4"><?php echo htmlspecialchars($opmerking); ?></textarea>
                </div>

                <button type="submit" class="button-primary">Opslaan</button>
            </form>
        </div>
    </div>
</section>

<?php require_once __DIR__ . '/../../../includes/footer.php'; ?>