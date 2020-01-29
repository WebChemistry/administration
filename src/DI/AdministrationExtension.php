<?php declare(strict_types = 1);

namespace WebChemistry\Administration\DI;

use Nette\DI\CompilerExtension;
use Nette\DI\Definitions\Statement;
use Nette\Schema\Expect;
use Nette\Schema\Schema;
use WebChemistry\Administration\Components\Entities\Menu;
use WebChemistry\Administration\Components\Entities\MenuChild;
use WebChemistry\Administration\Components\MenuComponent;
use WebChemistry\Administration\Providers\CdnLinkProvider;
use WebChemistry\Administration\Providers\HomepageLinkProvider;
use WebChemistry\Macros\DI\EmbedMacroExtension;
use WebChemistry\Macros\EmbedAliases;

final class AdministrationExtension extends CompilerExtension {

	private const VERSION = '1.0.1';

	public function getConfigSchema(): Schema {
		return Expect::structure([
			'menu' => Expect::arrayOf(Expect::structure([
				'name' => Expect::string()->required(),
				'icon' => Expect::string(),
				'url' => Expect::type('array|string'),
				'children' => Expect::arrayOf(Expect::structure([
					'name' => Expect::string()->required(),
					'icon' => Expect::string(),
					'url' => Expect::type('array|string'),
				]))
			])),
			'links' => Expect::structure([
				'homepage' => Expect::string('Homepage:'),
			]),
			'version' => Expect::string()
		]);
	}

	public function loadConfiguration() {
		$builder = $this->getContainerBuilder();
		$config = $this->getConfig();

		$builder->addDefinition($this->prefix('menu'))
			->setType(MenuComponent::class);

		$builder->addDefinition($this->prefix('homepageLinkProvider'))
			->setFactory(HomepageLinkProvider::class, [$config->links->homepage]);

		$builder->addDefinition($this->prefix('cdnLinkProvider'))
			->setFactory(CdnLinkProvider::class, [$config->version]);

		if ($config->menu) {
			$this->createMenu((array) $config->menu);
		}
	}

	public function beforeCompile(): void {
		$extensions = $this->compiler->getExtensions(EmbedMacroExtension::class);
		if (!$extensions) {
			return;
		}

		$builder = $this->getContainerBuilder();

		$builder->getDefinitionByType(EmbedAliases::class)
			->addSetup('addAlias', ['admin', __DIR__ . '/../Presenters/templates/blocks.latte']);
	}

	private function createChildren(array $items): array {
		$children = [];
		foreach ($items as $item) {
			$args = [];

			$args[] = $item->name;
			$args[] = (array) $item->url;
			$args[] = $this->createChildren($item->children ?? []);

			$children[] = new Statement(MenuChild::class, $args);
		}

		return $children;
	}

	private function createMenu(array $menu): void {
		$builder = $this->getContainerBuilder();

		$setup = [];
		foreach ($menu as $item) {
			$args = [];

			$args[] = $item->name;
			$args[] = (array) $item->url;
			$args[] = $item->icon;
			$args[] = null; // color
			$args[] = $this->createChildren($item->children ?? []);

			$setup[] = new Statement('addItem', [new Statement(Menu::class, $args)]);
		}

		$builder->getDefinition($this->prefix('menu'))
			->setSetup($setup);
	}

}
