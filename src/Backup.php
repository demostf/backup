<?php declare(strict_types=1);

namespace Demostf\Backup;

class Backup {
	const SUCCESS = 1;
	const FAIL = -1;
	const EMPTY_PAGE = 0;

	private $source;

	private $store;

	public function __construct(Source $source, Store $store) {
		$this->source = $source;
		$this->store = $store;
	}

	private function backupDemo(string $name, string $url, string $hash): bool {
        $encodedUrl = rawurlencode($url);
        $encodedUrl = str_replace('%2F', '/', $encodedUrl);
        $encodedUrl = str_replace('%3A//', '://', $encodedUrl);
		$handle = fopen($encodedUrl, 'r');
		$storedHash = $this->store->store($name, $handle);
		return $hash === '' || $hash === $storedHash;
	}

	public function backupPage(int $page): int {
		$demos = $this->source->listDemos($page, 'ASC');
		if (count($demos) === 0) {
			return self::EMPTY_PAGE;
		}
		foreach ($demos as $demo) {
			$url = $demo['url'];
			$name = basename($url);
			if (!$this->store->exists($name)) {
				if (!$this->backupDemo($name, $url, $demo['hash'])) {
					echo "hash mismatch\n";
					return self::FAIL;
				}
			}
		}
		return self::SUCCESS;
	}

	public function backupFrom(int $startPage): int {
		$currentPage = $startPage;
		while ($this->backupPage($currentPage) === self::SUCCESS) {
			$currentPage++;
		}
		return $currentPage;
	}
}
