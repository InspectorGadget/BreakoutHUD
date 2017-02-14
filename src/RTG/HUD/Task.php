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

/**
 * Description of Task
 *
 * @author RTG
 */

/* Essentials */
use pocketmine\utils\Config;
use pocketmine\Server;
use pocketmine\Player;
use pocketmine\scheduler\PluginTask;

class Task extends PluginTask {
    
    public function __construct($owner) {
        $this->owner = $owner;
        parent::__construct($owner);
        $this->count = Task::COUNT;
    }
    
    public function onRun($currentTick) {
       
        foreach($this->getServer()->getOnlinePlayers() as $p) {
            
            if($this->owner->hudOn($p) === TRUE) {
                
                $msg = $this->owner->msgGet($this->count, $p);
                $p->setTip($msg);
                $this->count++;
                
            }
            
            // More checker
            if($this->count >= $this->owner->check) {
                $this->count -= $this->owner->check;
            }
             
        }

    }
    
}