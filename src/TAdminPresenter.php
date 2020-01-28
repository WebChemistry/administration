<?php declare(strict_types = 1);

namespace WebChemistry\Administration;

use Nette\Application\ForbiddenRequestException;
use WebChemistry\Administration\Authorizator\IAdministratorAuthorizator;
use WebChemistry\Administration\Providers\CdnLinkProvider;

trait TAdminPresenter {

	/** @var IAdministratorAuthorizator */
	private $administratorAuthorizator;

	/** @var CdnLinkProvider */
	private $linkProvider;

	final public function injectTAdminPresenter(IAdministratorAuthorizator $administratorAuthorizator,
												CdnLinkProvider $linkProvider) {
		$this->administratorAuthorizator = $administratorAuthorizator;
		$this->linkProvider = $linkProvider;
	}

	protected function startup() {
		parent::startup();

		if (!$this->getUser()->isLoggedn() && !$this->isLinkCurrent('Sign:*')) {
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
		$template->assetsPath = $this->linkProvider->getAssetsLink();
	}

}
