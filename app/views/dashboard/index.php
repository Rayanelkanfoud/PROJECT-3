<h1><?= $data['title']; ?></h1>

<p>Welkom <?= htmlspecialchars($_SESSION['user_naam']); ?></p>
<p>Je bent ingelogd met <?= htmlspecialchars($_SESSION['user_email']); ?></p>

<a href="<?= URLROOT; ?>/auth/logout">Uitloggen</a>