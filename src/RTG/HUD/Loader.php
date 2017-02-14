<?php

/* 
 * Copyright (C) 2017 RTG
 *
 * This program is free software; you can redistribute it and/or
 * modify it under the terms of the GNU General Public License
 * as published by the Free Software Foundation; either version 2
 * of the License, or (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program; if not, write to the Free Software
 * Foundation, Inc., 59 Temple Place - Suite 330, Boston, MA  02111-1307, USA.
 */

namespace RTG\HUD;

/* Essentials */
use pocketmine\plugin\PluginBase;
use pocketmine\utils\Config;
use pocketmine\command\CommandExecutor;
use pocketmine\Server;
use pocketmine\Player;

class Loader extends PluginBase {
    
    public $economy;
    public $cfg;
    public $on;
    public $check;
    
    public function onEnable() {
       @mkdir ($this->getDataFolder());
       $this->cfg = new Config($this->getDataFolder() . "config.yml");
       $this->economy = $this->getServer()->getPluginManager()->getPlugin("EconomyAPI");
       $c = new CMD\HUDCommand($this);
       $this->check = count($this->cfg->get("messages"));
       $this->on = array();
       
       if($this->getServer()->getPluginManager()->getPlugin("EconomyAPI") === false) {
           $this->getLogger()->warning("Please install EconomyAPI by onebone!");
           $this->setEnabled(false);
       }
       else {
           $this->getLogger()->info("EconomyAPI has been found!");
       }
       
       $this->getLogger()->info("Breakout HUD has been enabled!");
    }
    
    public function hudOn(Player $p) {
        
        if(isset($this->on[strtolower($p->getName())])) {
            return $this->getLogger()->info("Enabled!");
        }
        
    }
    
    public function msgGet($now, $p) {
        
        $msg = $this->cfg->get("messages");
        return $this->format($msg[$now], $p);
        
    }
    
    public function format($msg, Player $p) {
        
        $msg = str_replace("{LINE}", "\n", $msg);
        $msg = str_replace("{NAME}", $p->getName(), $msg);
        
        if($this->economy != NULL) {
            $msg = str_replace("{MONEY}", $this->economy->myMoney($p), $msg);
        }
        
        return $msg;

    }
    
    public function onDisable() {
        parent::onDisable();
    }
     
}