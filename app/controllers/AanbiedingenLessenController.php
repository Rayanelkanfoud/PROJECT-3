<?php

$aanbiedingenBeschikbaar = true;

if ($aanbiedingenBeschikbaar) {
    require_once '../app/views/aanbiedingenlessen/index.php';
} else {
    require_once '../app/views/aanbiedingenlessen/fout.php';
}