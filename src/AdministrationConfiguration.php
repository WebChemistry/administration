<?php declare(strict_types = 1);

namespace WebChemistry\Administration;

use Nette\Security\User;
use Nette\SmartObject;

final class AdministrationConfiguration implements IAdministrationConfiguration {

	use SmartObject;

	/** @var User */
	private $user;

	public function __construct(User $user) {
		$this->user = $user;
	}

	public function getAvatar(): ?string {
		return null;
	}

	public function isCurrentUserAdministrator(): bool {
		return $this->user->isLoggedIn();
	}

	public function getHomepageDestination(): string {
		return 'Homepage:';
	}

}
