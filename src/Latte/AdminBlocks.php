<?php declare(strict_types = 1);

namespace WebChemistry\Administration\Latte;

final class AdminBlocks
{

	public static function getPanel(): string
	{
		return __DIR__ . '/templates/panel.latte';
	}

	public static function getBox(): string
	{
		return __DIR__ . '/templates/box.latte';
	}

}
