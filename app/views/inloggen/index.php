<?php require_once __DIR__ . '/../../../includes/header.php'; ?>

<section class="inloggen-hero">
    <div class="container">
        <p class="inloggen-badge">Inloggen</p>
        <h1>Log in op je account</h1>
        <p class="inloggen-intro">
            Vul hieronder je e-mailadres en wachtwoord in om toegang te krijgen tot het systeem.
        </p>
    </div>
</section>

<section class="inloggen-sectie">
    <div class="container">
        <div class="inloggen-box">
            <form method="POST" action="" class="inloggen-formulier">
                <label for="email">E-mailadres</label>
                <input
                    type="email"
                    id="email"
                    name="email"
                    placeholder="Bijvoorbeeld rayan@fitforfun.nl"
                    value="<?php echo htmlspecialchars($email); ?>"
                >

                <label for="wachtwoord">Wachtwoord</label>
                <input
                    type="password"
                    id="wachtwoord"
                    name="wachtwoord"
                    placeholder="Vul je wachtwoord in"
                >

                <button type="submit" class="button-primary">Inloggen</button>
            </form>

            <?php if ($foutmelding !== ''): ?>
                <div class="inloggen-melding inloggen-melding--fout">
                    <?php echo htmlspecialchars($foutmelding); ?>
                </div>
            <?php endif; ?>

            <?php if (isset($_GET['fout']) && $_GET['fout'] === 'uitloggen'): ?>
                <div class="inloggen-melding inloggen-melding--fout">
                    Uitloggen is niet gelukt.
                </div>
            <?php endif; ?>

            <?php if (isset($_GET['succes']) && $_GET['succes'] === 'uitgelogd'): ?>
                <div class="inloggen-melding">
                    Je bent succesvol uitgelogd.
                </div>
            <?php endif; ?>
        </div>
    </div>
</section>

<?php require_once __DIR__ . '/../../../includes/footer.php'; ?>