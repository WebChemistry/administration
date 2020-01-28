<?php declare(strict_types = 1);

namespace WebChemistry\Administration\Authorizator;

use Nette\Security\User;

interface IAdministratorAuthorizator {

	public function isAdministrator(User $user): bool;

}