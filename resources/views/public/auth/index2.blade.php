@extends('layouts.public.app')

@section('title','Se Connecter')

@section('content')
    <div class="container top25vh">
        <div class="row d-flex justify-content-center align-items-center">
            <div class="col-6 text-center firstSquare text-white d-flex justify-content-center align-items-center">
                <div class="col-3">
                    <img src="img/authImg001.png" alt="img" class="img001Auth d-flex justify-content-center align-content-center">
                </div>
                <div class="col-9">
                    <p class="Nunito200">Vous n'avez pas de compte ?</p>
                    <h1 class="Nunito400 customPurple">inscription</h1>
                </div>
            </div>
        </div>

        <div class="mt-5 mb-5"></div>

        <div class="row d-flex justify-content-center align-items-center">
            <div class="col-6 text-center secondSquare text-white d-flex flex-column justify-content-center">
                <button class="btn btn-primary d-flex justify-content-center align-items-center bgPurple"><i class="bi bi-discord" style="color: white;font-size: 4rem"></i>&nbsp;<span class="txtButtonAuth Nunito400">connexion</span></button>
            </div>
        </div>
    </div>
@endsection
