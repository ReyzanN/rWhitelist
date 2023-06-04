<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Session;

class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;

    public function setFailure($Message): void
    {
        Session::flash('Failure',$Message);
    }

    public function setSuccess($Message): void
    {
        Session::flash('Success',$Message);
    }

    /*
     * Tools
     */
    public function Exist($ClassName,$Id){
        $Temp = $ClassName::find($Id);
        if ($Temp){
            return $Temp;
        }
        return false;
    }
}
