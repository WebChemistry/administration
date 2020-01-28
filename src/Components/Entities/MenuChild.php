<?php declare(strict_types = 1);

namespace WebChemistry\Administration\Components\Entities;

class MenuChild {

	/** @var string */
	private $name;

	/** @var array */
	private $url;

	/** @var MenuChild[] */
	private $children = [];

	public function __construct(string $name, array $url, array $children = []) {
		$this->name = $name;
		$this->url = $url;
		foreach ($children as $child) {
			$this->addChild($child);
		}
	}

	/**
	 * @return static
	 */
	public function addChild(MenuChild $child) {
		$this->children[] = $child;

		return $this;
	}

	public function getName(): string {
		return $this->name;
	}

	public function getUrl(): array {
		return $this->url;
	}

	/**
	 * @return MenuChild[]
	 */
	public function getChildren(): array {
		return $this->children;
	}

}
