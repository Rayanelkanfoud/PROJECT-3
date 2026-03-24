<?php require_once __DIR__ . '/../../../includes/header.php'; ?>

<section class="ledenperiode-hero">
    <div class="container">
        <p class="ledenperiode-badge">Overzicht aantal leden per periode</p>
        <h1>Bekijk het aantal leden per gekozen periode</h1>
        <p class="ledenperiode-intro">
            Kies hieronder een maand en bekijk direct hoeveel leden in die periode geregistreerd zijn.
        </p>
    </div>
</section>

<section class="ledenperiode-sectie">
    <div class="container">
        <div class="ledenperiode-box">
            <form method="POST" action="" class="ledenperiode-formulier">
                <div class="ledenperiode-formulier-groep">
                    <label for="periode">Periode</label>
                    <input
                        type="month"
                        id="periode"
                        name="periode"
                        value="<?php echo htmlspecialchars($periode); ?>"
                    >
                </div>

                <button type="submit" class="button-primary">Bekijken</button>
            </form>

            <?php if ($foutmelding !== ''): ?>
                <div class="ledenperiode-melding ledenperiode-melding--fout">
                    <?php echo htmlspecialchars($foutmelding); ?>
                </div>
            <?php endif; ?>

            <?php if ($totaalLeden !== null && $foutmelding === ''): ?>
                <div class="ledenperiode-resultaat">
                    <h2>Resultaat voor <?php echo htmlspecialchars($periode); ?></h2>
                    <div class="ledenperiode-kaart">
                        <span class="ledenperiode-aantal"><?php echo $totaalLeden; ?></span>
                        <p>geregistreerde leden</p>
                    </div>
                </div>
            <?php endif; ?>

            <?php if (!empty($beschikbarePeriodes)): ?>
                <div class="ledenperiode-beschikbaar">
                    <h3>Beschikbare periodes in de database</h3>
                    <div class="ledenperiode-tags">
                        <?php foreach ($beschikbarePeriodes as $item): ?>
                            <span class="ledenperiode-tag">
                                <?php echo htmlspecialchars($item['periode']); ?>
                            </span>
                        <?php endforeach; ?>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </div>
</section>

<?php require_once __DIR__ . '/../../../includes/footer.php'; ?>