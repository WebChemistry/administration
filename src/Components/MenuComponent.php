<?php declare(strict_types = 1);

namespace WebChemistry\Administration\Components;

use Nette\Application\UI\Control;
use WebChemistry\Administration\Components\Entities\Menu;

final class MenuComponent extends Control {

	/** @var Menu[] */
	private $items;

	public function addItem(Menu $menu) {
		$this->items[] = $menu;

		return $this;
	}

	public function render(): void {
		if (!$this->items) {
			return;
		}
		$template = $this->getTemplate();
		$template->setFile(__DIR__ . '/templates/menu.latte');

		$template->items = $this->items;

		$template->render();
	}

}
