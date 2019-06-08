<?php declare(strict_types=1);

use ZanBaldwin\DPC19\App;
use ZanBaldwin\DPC19\Obfuscation;

require __DIR__ . '/../vendor/autoload.php';

$filterName = 'dpc19';
Obfuscation\ObfuscatingTransformFilter::register($filterName);
Obfuscation\AutoloaderOverloader::init($filterName);

$controller = new App\Controller;
$controller('DPC19');
