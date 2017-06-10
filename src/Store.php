<?php declare(strict_types=1);

namespace Demostf\Backup;

class Store {
	private $baseDir;

	public function __construct($baseDir) {
		$this->baseDir = $baseDir;
	}

	public function store(string $name, $handle): string {
		$path = $this->generatePath($name);
		if (!is_dir(dirname($path))) {
			mkdir(dirname($path), 0775, true);
		}
		file_put_contents($path, $handle);
		echo "$name\n";
		return md5_file($path);
	}

	private function generatePath(string $name): string {
		return $this->baseDir . $this->getPrefix($name) . $name;
	}

	private function getPrefix(string $name): string {
		return '/' . substr($name, 0, 2) . '/' . substr($name, 2, 2) . '/';
	}

	public function exists(string $name): bool {
		return file_exists($this->generatePath($name));
	}
}