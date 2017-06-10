<?php declare(strict_types=1);

namespace Demostf\Backup;

class Source {
	private $endpoint;

	public function __construct($endpoint) {
		$this->endpoint = $endpoint;
	}

	public function listDemos(int $page = 0, string $order = 'DESC'): array {
		$url = $this->endpoint . '/demos?page=' . $page . '&order=' . $order;
		$content = file_get_contents($url);
		$demos = json_decode($content, true);
		foreach ($demos as $data) {
			$date = new \DateTime();
			$date->setTimestamp($data['time']);
			$data['time'] = $date;
		}
		return $demos;
	}
}