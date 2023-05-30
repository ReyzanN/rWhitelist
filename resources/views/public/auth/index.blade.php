@extends('layouts.public.app')

@section('title','Se Connecter')

@section('content')
    <div class="container top25vh">
        <div class="row d-flex justify-content-center align-items-center">
            <div class="col-6 text-center firstSquare text-white d-flex justify-content-center align-items-center rounded">
                <div class="col-3">
                    <img src="img/authImg001.png" alt="img" class="img001Auth d-flex justify-content-center align-content-center">
                </div>
                <div class="col-9">
                    <p class="Nunito200">Classic</p>
                    <h1 class="Nunito400 customPurple">Whitelist</h1>
                </div>
            </div>
        </div>

        <div class="mt-5 mb-5"></div>

        <div class="row d-flex justify-content-center align-items-center">
            <div class="col-6 text-center secondSquare text-white d-flex flex-column justify-content-center rounded">
                <a href="{{ route('auth.login') }}" class="noStyle justify-content-center align-items-center">
                    <button class="btn btn-primary d-flex justify-content-center align-items-center bgPurpleButton txtButtonAuth Nunito400 w-100">
                        <i class="bi bi-discord" style="color: white;font-size: 4rem"></i>&nbsp;connexion
                    </button>
                </a>
            </div>
        </div>
    </div>
@endsection
