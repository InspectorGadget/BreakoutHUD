<?php

namespace RTG\HUD\CMD;

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

/**
 * Description of HUDCommand
 *
 * @author RTG
 */

use RTG\HUD\Loader;

use pocketmine\utils\Config;
use pocketmine\command\CommandExecutor;
use pocketmine\command\Command;
use pocketmine\command\CommandSender;

class HUDCommand implements CommandExecutor {
    
    public $plugin;
    
    public function __construct(Loader $plugin) {
        $this->plugin = $plugin;
    }
    
    public function onCommand(CommandSender $sender, Command $command, $label, string $args) {
        switch(strtolower($command->getName())) {
            
            case "hud":
                
                if(isset($args[0])) {
                    switch(strtolower($args[0])) {
                        
                        case "toggle":
                
                            if(isset($this->plugin->on[strtolower($sender->getName())])) {
                                unset($this->plugin->on[strtolower($sender->getName())]);
                                $sender->sendMessage("HUD is now off!");
                            }
                            else {
                                $this->plugin->on[strtolower($sender->getName())] = strtolower($sender->getName());
                                $this->plugin->on->save();
                                $sender->sendMessage("HUD is now on!");
                            }
                            
                            return true;
                        break;
                        
                        case "help":
                            
                            $sender->sendMessage("[HUD] /hud toggle");
                            
                            return true;
                        break;
                        
                    }
                }
                else {
                    $sender->sendMessage("Usage: /hud help");
                }
                
                return true;
            break;
               
        }
    }
      
}