<?php

namespace HCFDeaths;

use pocketmine\plugin\PluginBase;
use pocketmine\event\Listener;
use pocketmine\utils\TextFormat;
use pocketmine\utils\Utils;
use pocketmine\utils\Config;
use pocketmine\math\Vector3;
use pocketmine\Player;
use pocketmine\inventory\PlayerInventory;
use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\command\CommandExecutor;
use pocketmine\block\Block;
use pocketmine\item\Item;
use pocketmine\level\Level;
use pocketmine\Server;
use pocketmine\entity\Effect;
use pocketmine\item\enchantment\Enchantment;

use pocketmine\event\player\PlayerPreLoginEvent;
use pocketmine\event\player\PlayerLoginEvent;
use pocketmine\event\player\PlayerJoinEvent;
use pocketmine\event\player\PlayerQuitEvent;
use pocketmine\event\player\PlayerRespawnEvent;
use pocketmine\event\player\PlayerMoveEvent;
use pocketmine\event\player\PlayerInteractEvent;
use pocketmine\event\block\BlockPlaceEvent;
use pocketmine\event\block\BlockBreakEvent;
use pocketmine\event\player\PlayerCommandPreprocessEvent;
use pocketmine\event\server\ServerCommandEvent;
use pocketmine\event\server\RemoteServerCommandEvent;
use pocketmine\event\player\PlayerChatEvent;
use pocketmine\event\player\PlayerItemHeldEvent;
use pocketmine\event\entity\EntityDamageEvent;
use pocketmine\event\entity\EntityDamageByEntityEvent;
use pocketmine\event\player\PlayerDeathEvent;

class main extends PluginBase implements Listener{

public function sendStatus($msg){
$url = "https://discordapp.com/api/webhooks/419842008283086850/7F6BfX9_lp2KU9jmz1UXoRSZnzKx0AigRV5mtsg_n9PiWX4ZNdI8Y7bDLUd-7bd47UmZ";
$data = array("content" => $msg, "username" => "Matts plugins.");
$curl = curl_init($url);
curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "POST");
curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($data));
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
return curl_exec($curl);
}

public function onEnable(){
$this->getServer()->getPluginManager()->registerEvents($this, $this);
/*$this->saveDefaultConfig();*/
$this->sendStatus($this->getServer()->getMotd() . " just enabled HCFDeaths");
}

public function deathBan($p, $str){
$path = "deaths/";
$file = strtolower($p);
if(!file_exists($this->getDataFolder() . $path . $file . ".yml")){
@mkdir($this->getDataFolder() . $path, 0777, true);
$config = new Config($this->getDataFolder() . $path . $file . ".yml", Config::YAML, ["time" => $str]);
}
}

public function undeathBan($p){
$path = "deaths/";
$file = strtolower($p);
if(file_exists($this->getDataFolder() . $path . $file . ".yml")){
unlink($this->getDataFolder() . $path . $file . ".yml");
}
}

public function banExists($p): bool {
$path = "deaths/";
$file = strtolower($p);
if(file_exists($this->getDataFolder() . $path . $file . ".yml")){
return true;
} else {
return false;
}
}

public function getBanTime($p): int {
$path = "deaths/";
$file = strtolower($p);
if(file_exists($this->getDataFolder() . $path . $file . ".yml")){
$config2 = new Config($this->getDataFolder() . $path . $file . ".yml", Config::YAML);
$current = $config2->get("time");
return $current;
}
}

public function addLife($p, $str){
$path = "lives/";
$file = strtolower($p);
if(!file_exists($this->getDataFolder() . $path . $file . ".yml")){
@mkdir($this->getDataFolder() . $path, 0777, true);
public function removeLife($p){
$path = "lives/";
$file = strtolower($p);
if(file_exists($this->getDataFolder() . $path . $file . ".yml")){
unlink($this->getDataFolder() . $path . $file . ".yml");
}
}

public function handleLife($p){
$path = "lives/";
$file = strtolower($p);
if(file_exists($this->getDataFolder() . $path . $file . ".yml")){
$config2 = new Config($this->getDataFolder() . $path . $file . ".yml", Config::YAML);
$current = $config2->get("lives");
if($current == 1){
$this->removeLife($p);
}
}
}

public function onDeath(PlayerDeathEvent $event){
$ent = $event->getEntity();
$cause = $ent->getLastDamageCause();
if($cause instanceof EntityDamageByEntityEvent){
$killer = $cause->getDamager();
$weapon = $killer->getInventory()->getItemInHand()->getName();
$event->setDeathMessage("ยงe" . $ent->getName() . " was slain by " . $killer->getName() . " using " . $weapon);
}
}

public function onRespawn(PlayerRespawnEvent $event){
$old = microtime();
$this->deathBan($ent, $old);
}

public function onJoin(PlayerJoinEvent $event){
$p = $event->getPlayer();
$new = microtime();
if($this->banExists($p)){
if($new - $this->getBanTime($p) > 300000){
$this->undeathBan($p);
} else {
$p->kick(TextFormat::RED . "Death banned.\nPlease wait untill your ban time is over.", false);
}
}
}

public function onCommand(CommandSender $sender, Command $command, $label, array $args): bool {
switch(strtolower($command->getName())){
case "addlive":
if(isset($args[0])){
$p = $this->getServer()->getPlayer($args[0]);
}
break;
}
}

}
