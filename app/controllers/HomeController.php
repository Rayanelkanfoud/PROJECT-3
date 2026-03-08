<?php

// Hiermee kun je testen of de website in onderhoud staat
$websiteInOnderhoud = false;

// Als de website in onderhoud staat, toon dan de onderhoudspagina
if ($websiteInOnderhoud) {
    require_once '../app/views/home/onderhoud.php';
} else {
    // Happy flow: normale homepagina tonen
    require_once '../app/views/home/index.php';
}