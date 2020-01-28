<?php declare(strict_types = 1);

namespace WebChemistry\Administration\Authorizator;

use Nette\Security\User;
use Nette\SmartObject;

final class AdministratorAuthorizator implements IAdministratorAuthorizator {

	use SmartObject;

	public function isAdministrator(User $user): bool {
		return $user->isLoggedIn();
	}

}
