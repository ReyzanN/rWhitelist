<?php

namespace App\Models;

trait tools
{
    public function parseDateToString(string|\DateTime $Date){
        if (!is_string($Date)){
            return $Date->format('d/m/y - H:i');
        }else{
            $TempDate = new \DateTime($Date);
            return $TempDate->format('d/m/y - H:i');
        }
    }

    public function isExist(){
        try {
            $this->getMorphClass();
            dd($this->getMorphClass());
        }catch (\Exception $e){
        }
    }
}
