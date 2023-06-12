<?php

namespace App\Http\Controllers;

use App\Http\Requests\SteamIDUpdateRequest;
use App\Http\Requests\UserAccountInformationUpdate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class UsersController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth']);
    }

    public function UpdateInformation(UserAccountInformationUpdate $request): \Illuminate\Http\RedirectResponse
    {
        if ($request->validated()){
            try {
                auth()->user()->update([
                    'steamId' => $request->only('steamid')['steamid'],
                    'birthdate' => $request->only('birthdate')['birthdate']
                ]);
                Session::flash('Success','Modification réalisé avec succès');
            }catch (\Exception $e){
                Session::flash('Failure','Une erreur est survenue');
            }
        }
        return redirect()->back();
    }
}
