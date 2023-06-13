<?php

namespace App\Models;

use Faker\Core\DateTime;

trait tools
{
    public function parseDateToString(string|\DateTime $Date): string
    {
        if (!is_string($Date)){
            return $Date->format('d/m/y - H:i:s');
        }else{
            $TempDate = new \DateTime($Date);
            return $TempDate->format('d/m/y - H:i:s');
        }
    }

    public function parseDateToTime(string|\DateTime $Date): string
    {
        if (!is_string($Date)){
            return $Date->format('H:i');
        }else{
            $TempDate = new \DateTime($Date);
            return $TempDate->format('H:i');
        }
    }

    public function parseDateToStringWithDay(string|\DateTime $Date): string{
        $DayList = ['Lundi','Mardi','Mercredi','Jeudi','Vendredi','Samedi','Dimanche'];
        $MouthList = ['Janvier','Février','Mars','Avril','Mai','Juin','Juillet','Août','Septembre','Octobre','Novembre','Décembre'];
        if (!is_string($Date)){
            $Day = intval($Date->format('w')-1);
            $DayNumber = $Date->format('d');
            $Mouth = intval($Date->format('m')-1);
            return $DayList[$Day].' '.$DayNumber.' '.$MouthList[$Mouth];
        }else{
            $TempDate = new \DateTime($Date);
            $Day = intval($TempDate->format('w')-1);
            $DayNumber = $TempDate->format('d');
            $Mouth = intval($TempDate->format('m')-1);
            return $DayList[$Day].' '.$DayNumber.' '.$MouthList[$Mouth];
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
