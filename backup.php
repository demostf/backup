<?php declare(strict_types=1);

require 'vendor/autoload.php';

if (!getenv('STORAGE_ROOT')) {
	$env = new \Dotenv\Dotenv(__DIR__);
	$env->load();
}

$store = new \Demostf\Backup\Store(getenv('STORAGE_ROOT'));
$source = new \Demostf\Backup\Source(getenv('SOURCE'));
$statePath = getenv('STATE_FILE');


if (file_exists($statePath)) {
	$lastPage = intval(file_get_contents($statePath)) - 1;
	if ($lastPage < 1) {
		$lastPage = 1;
	}
} else {
	$lastPage = 1;
}
$backup = new \Demostf\Backup\Backup($source, $store);

$currentPage = $backup->backupFrom($lastPage);

file_put_contents($statePath, $currentPage);
