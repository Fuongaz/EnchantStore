<?php
declare(strict_types=1);
namespace phuongaz\EnchantForm;

use pocketmine\command\{
	Command,
	CommandSender
};

use pocketmine\PLayer;

Class EnchantCommands extends Command {

	public function __construct(){
		parent::__construct("enchantshop", "Enchant shop", '/enchantshop', ['ecshop', 'buyec']);
	}

	public function execute(CommandSender $sender, string $label, array $args) :bool{

		if($sender instanceof Player) {
			Enchant::sendForm($sender);
		}
		return true;
	}

}