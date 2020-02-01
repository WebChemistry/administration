<?php declare(strict_types = 1);

namespace WebChemistry\Administration\Presenters;

use WebChemistry\Administration\AdminPresenter;
use WebChemistry\Administration\IAdministrationConfiguration;
use WebChemistry\NetteInterfaces\Factories\ISignInFormFactory;

class SignPresenter extends AdminPresenter {

	/** @var IAdministrationConfiguration @inject */
	public $administrationConfiguration;

	/** @var ISignInFormFactory @inject */
	public $signInFormFactory;

	public function actionIn(?string $backlink): void {
		if ($this->getUser()->isLoggedIn()) {
			$this->redirect($this->administrationConfiguration->getHomepageDestination());
		}

		$template = $this->getTemplate();

		$template->setFile($parentFile = __DIR__ . '/templates/Sign/in.latte');
		$template->parentFile = $parentFile;
	}

	public function actionOut(): void {
		if ($this->getUser()->isLoggedIn()) {
			$this->getUser()->logout();
		}

		$this->redirect('in');
	}

	protected function createComponentSignIn() {
		$form = $this->signInFormFactory->createSignInForm();

		$form->onSuccess[] = function () {
			if ($this->getParameter('backlink')) {
				$this->redirectUrl($this->getParameter('backlink'));
			}

			$this->redirect($this->administrationConfiguration->getHomepageDestination());
		};

		return $form;
	}

}
