<?php

declare(strict_types=1);

namespace phuongaz\EnchantForm;

use jojoe77777\FormAPI\{
	SimpleForm,
	CustomForm
};

use pocketmine\utils\TextFormat as TF;
use pocketmine\Player;


use pocketmine\item\{
	Item,
	enchantment\Enchantment
};
Class Forms {

	public static function MainForm( $player) {
		$form = new SimpleForm(function(Player $player, ?int $data){
			if(is_null($data)) return;
			if(is_null(Enchant::$enchantments[$data])) return;
			self::ConfirmForm(Enchant::$enchantments[$data], $player);
		});

		$form->setTitle("Enchantment UI");
		$form->setContent("Choose one enchant to see info it");
		foreach(Enchant::$enchantments as $enchant){
			$form->addButton(TF::BOLD. TF::GREEN. " > ". TF::YELLOW. $enchant->getName(). TF::GREEN. " <");
		}
		$form->sendToPlayer($player);
	}

	public static function ConfirmForm(Enchantment $enchantment, Player $player) {
		$form = new CustomForm(function(Player $player, ?array $data) use ($enchantment){
			if(is_null($data)) return;
			if(Enchant::getInstance()->checkMoney($player, round($data[2]))){
				Enchant::getInstance()->EnchantItem($player, $enchantment, (int)$data[2]);
			}else self::CustomForm($player, "Not enough money");
		});

		$form->setTitle("Confirm Enchantment");
		$form->addLabel("Enchantment: ". $enchantment->getName());
	//	$form->addLabel("Max level enchant: ".$enchantment->getMaxLevel());
		$form->addLabel("Your money :". Enchant::getInstance()->getEco()->myMoney($player));
		$form->addSlider(Enchant::$money ." / 1 Level", 1, 5 , 1);
		$form->sendToPlayer($player);
	}

	public static function CustomForm(Player $player, string $string, ?Item $item = null) {
		$form = new CustomForm(function(Player $player, $data){ if(is_null($data)) return; });
		$form->setTitle("Notice");
		$form->addLabel($string);
		if($item !== null){
			$form->addLabel("Enchantments:");
			//$form->addLabel("Name Item: ". $item->getCustomName());
			foreach($item->getEnchantments() as $enchant){
				$enchantm = $enchant->getType();
				$form->addLabel("Name: ". $enchantm->getName(). " | Level: ". $enchant->getLevel()); 
			}
		}
		$form->sendToPlayer($player);
		return;
	}
}