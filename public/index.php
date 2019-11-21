<?php declare(strict_types=1);

use ZanBaldwin\SfCon19\App;
use ZanBaldwin\SfCon19\Obfuscation;

require __DIR__ . '/../vendor/autoload.php';

$filterName = 'sfcon2019';
Obfuscation\ObfuscatingTransformFilter::register($filterName);
Obfuscation\AutoloaderOverloader::init($filterName);

$controller = new App\Controller;
$controller('SfCon19');
