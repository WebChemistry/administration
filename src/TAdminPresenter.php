<?php declare(strict_types = 1);

namespace WebChemistry\Administration;

use Nette\Application\ForbiddenRequestException;
use WebChemistry\Administration\Authorizator\IAdministratorAuthorizator;
use WebChemistry\Administration\Components\MenuComponent;
use WebChemistry\Administration\Providers\CdnLinkProvider;
use WebChemistry\Administration\Providers\HomepageLinkProvider;

trait TAdminPresenter {

	/** @var IAdministratorAuthorizator */
	private $administratorAuthorizator;

	/** @var CdnLinkProvider */
	private $linkProvider;

	/** @var MenuComponent */
	private $menuComponent;

	/** @var HomepageLinkProvider */
	private $homepageLinkProvider;

	final public function injectTAdminPresenter(IAdministratorAuthorizator $administratorAuthorizator,
												CdnLinkProvider $linkProvider, MenuComponent $menuComponent,
												HomepageLinkProvider $homepageLinkProvider) {
		$this->administratorAuthorizator = $administratorAuthorizator;
		$this->linkProvider = $linkProvider;
		$this->menuComponent = $menuComponent;
		$this->homepageLinkProvider = $homepageLinkProvider;
	}

	protected function startup() {
		parent::startup();

		if (!$this->getUser()->isLoggedIn() && !$this->isLinkCurrent('Sign:*')) {
			$this->redirect('Sign:in', ['backlink' => $this->link('this')]);
		}

		if (!$this->administratorAuthorizator->isAdministrator($this->getUser())) {
			throw new ForbiddenRequestException('User is not an administrator');
		}
	}

	public function formatLayoutTemplateFiles(): array {
		$list = parent::formatLayoutTemplateFiles();
		$list[] = $this->getBaseLayout();

		return $list;
	}

	protected function getBaseLayout(): string {
		return __DIR__ . '/Presenters/templates/@layout.latte';
	}

	protected function beforeRender() {
		parent::beforeRender();

		$template = $this->getTemplate();

		$template->parentLayout = $this->getBaseLayout();
		$template->homepageLink = $this->link($this->homepageLinkProvider->getLink());
		$template->assetsPath = $this->linkProvider->getAssetsLink();
	}

	protected function createComponentMenu(): MenuComponent {
		return $this->menuComponent;
	}

}
