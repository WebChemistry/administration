<?php declare(strict_types = 1);

namespace WebChemistry\Administration\Providers;

use Nette\SmartObject;

/**
 * @internal
 */
final class CdnLinkProvider {

	use SmartObject;

	/** @var string */
	public const VERSION = '1.0.6';

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
