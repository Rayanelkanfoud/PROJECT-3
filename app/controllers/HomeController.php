<?php

$websiteInOnderhoud = false;

if ($websiteInOnderhoud) {
    require_once '../app/views/home/onderhoud.php';
} else {
    require_once '../app/views/home/index.php';
}