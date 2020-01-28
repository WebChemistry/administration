<?php declare(strict_types = 1);

namespace WebChemistry\Administration\Providers;

use Nette\SmartObject;

final class CdnLinkProvider {

	use SmartObject;

	public const VERSION = '1.0.1';

	/** @var string */
	private $version;

	public function __construct(?string $version) {
		$this->version = $version ?? self::VERSION;
	}

	public function getBaseLink(): string {
		return 'https://cdn.jsdelivr.net/npm/@webchemistry/administration@' . $this->version;
	}

	public function getAssetsLink(): string {
		return $this->getBaseLink() . '/assets';
	}

}
