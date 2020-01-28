<?php declare(strict_types = 1);

namespace WebChemistry\Administration\Components\Entities;

class Menu extends MenuChild {

	/** @var null|string */
	private $icon;

	/** @var null|string */
	private $color;

	public function __construct(string $name, array $url, ?string $icon = null, ?string $color = null,
								array $children = []) {
		parent::__construct($name, $url, $children);
		$this->icon = $icon;
		$this->color = $color;
	}

	public function getIcon(): ?string {
		return $this->icon;
	}

	public function getColor(): ?string {
		return $this->color;
	}

}
