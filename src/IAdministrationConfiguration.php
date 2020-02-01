<?php declare(strict_types = 1);

namespace WebChemistry\Administration;

use Nette\Security\User;

interface IAdministrationConfiguration {

	public function getAvatar(): ?string;

	public function isCurrentUserAdministrator(): bool;

	public function getHomepageDestination(): string;

}
