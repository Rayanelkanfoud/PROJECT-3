<?php

// Hiermee kun je testen of de aanbiedingen beschikbaar zijn
$aanbiedingenBeschikbaar = true;

// Als aanbiedingen beschikbaar zijn, toon de aanbiedingenpagina
if ($aanbiedingenBeschikbaar) {
    require_once '../app/views/aanbiedingenlessen/index.php';
} else {
    // Unhappy flow: foutpagina tonen
    require_once '../app/views/aanbiedingenlessen/fout.php';
}