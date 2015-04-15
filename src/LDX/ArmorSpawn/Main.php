<?php

namespace LDX\ArmorSpawn;

use pocketmine\plugin\PluginBase;
use pocketmine\event\Listener;
use pocketmine\Player;
use pocketmine\event\player\PlayerRespawnEvent;
use pocketmine\item\Item;

class Main extends PluginBase implements Listener {

  public function onEnable() {
    $this->saveDefaultConfig();
    $c = yaml_parse(file_get_contents($this->getDataFolder() . "config.yml"));
    $this->armor = array($c["Head"],$c["Chest"],$c["Legs"],$c["Feet"]);
    $this->getServer()->getPluginManager()->registerEvents($this,$this);
  }

  public function onSpawn(PlayerRespawnEvent $event) {
    $p = $event->getPlayer();
    if($p->hasPermission("armorspawn") || $p->hasPermission("armorspawn.receive")) {
      for($i = 0; $i <= 3; $i++) {
        if($p->getInventory()->getArmorItem($i)->getID() == 0) {
          $p->getInventory()->setArmorItem($i,$this->getArmor($this->armor[$i],$i));
        }
      }
      $p->getInventory()->sendArmorContents($this->getServer()->getOnlinePlayers());
    }
  }

  public function getArmor($type,$slot) {
    $type = strtolower($type);
    if($type == "leather") {
      return Item::get(298 + $slot);
    } else if($type == "chainmail") {
      return Item::get(302 + $slot);
    } else if($type == "iron") {
      return Item::get(306 + $slot);
    } else if($type == "gold") {
      return Item::get(314 + $slot);
    } else if($type == "diamond") {
      return Item::get(310 + $slot);
    } else {
      return Item::get(0);
    }
  }

}
