<?php declare(strict_types = 1);

namespace WebChemistry\Administration\Providers;

use Nette\SmartObject;

final class HomepageLinkProvider {

	use SmartObject;

	/** @var string */
	private $link;

	public function __construct(string $link) {
		$this->link = $link;
	}

	public function getLink(): string {
		return $this->link;
	}

}
