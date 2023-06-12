<?php

namespace App\Models;

trait tools
{
    public function parseDateToString(string|\DateTime $Date){
        if (!is_string($Date)){
            return $Date->format('d/m/y - H:i:s');
        }else{
            $TempDate = new \DateTime($Date);
            return $TempDate->format('d/m/y - H:i:s');
        }
    }

    public function isSelected($IdToCheck) :bool|null {
        if ($this->id == $IdToCheck){ return "selected";}
        return "";
    }

    public function isActive():string {
        if ($this->active){
            return "selected";
        }
        return "";
    }
}
