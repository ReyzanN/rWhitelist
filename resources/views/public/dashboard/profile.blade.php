@extends('layouts.public.app')

@section('title','Mon Profile')

@section('content')
    <div class="container-fluid top10vh text-white">
        <div class="row-cols-12 d-flex flex-row d-flex justify-content-center">
            @include('layouts.public.nav')
            <div class="row col-9 d-flex justify-content-around poppins">
                <div class="col-11 bg-black rounded">
                    <div class="row mt-3">
                        <h3>Mes informations</h3>
                        <div class="mt-2 col-12 d-flex justify-content-around align-items-center">
                            <div class="col-5">
                                <div class="form-floating mb-3 text-black">
                                    <input type="text" class="form-control" id="steamID" placeholder="SteamID" value="{{ auth()->user()->steamId }}" readonly>
                                    <label for="steamID">SteamID</label>
                                </div>
                            </div>
                            <div class="col-5">
                                <div class="form-floating mb-3 text-black">
                                    <input type="date" class="form-control" id="steamID" placeholder="SteamID" value="{{ auth()->user()->birthdate }}" readonly>
                                    <label for="steamID">Date de naissance</label>
                                </div>
                            </div>
                        </div>
                        <div class="row d-flex justify-content-center align-items-center">
                            <div class="col-4 d-flex justify-content-center align-items-center">
                                <button class="btn btn-warning bgPurpleButton text-white" data-bs-toggle="modal" data-bs-target="#UpdateInfo"><i class="bi bi-pencil"></i>&nbsp;Modifier mes informations</button>
                            </div>
                        </div>
                    </div>
                    <div class="row mt-3 mb-3 d-flex justify-content-center align-items-center">
                        <hr class="w-75">
                    </div>
                    <div class="row">
                        <h3>Discord lié</h3>
                        <div class="mt-2 col-12 d-flex justify-content-around align-items-center flex-column">
                            <div class="alert alert-light" role="alert">
                                C'est simplement ce qui permet d'identifier votre compte auprès de discord, cette information ne nous permet pas de nous connecter ou d'utiliser votre compte. Pour plus d'information, contacter le support.
                            </div>
                            <div class="col-5">
                                <div class="form-floating mb-3 text-black">
                                    <input type="text" class="form-control" id="steamID" placeholder="SteamID" value="{{ auth()->user()->discordAccountId }}" readonly>
                                    <label for="steamID">Discord Account ID</label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Update Account Information -->
    <div class="modal fade" id="UpdateInfo" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="UpdateInfoLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content bg-black text-white poppins">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="UpdateInfoLabel">Modifier mes informations</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('users.updateInformation') }}" method="post">
                        @csrf
                        <div class="mt-2 col-12 d-flex justify-content-around align-items-center">
                            <div class="col-5">
                                <div class="form-floating mb-3 text-black">
                                    <input type="text" class="form-control" id="steamid" name="steamid" placeholder="SteamID" value="{{ auth()->user()->steamId }}">
                                    <label for="steamid">SteamID</label>
                                </div>
                            </div>
                            <div class="col-5">
                                <div class="form-floating mb-3 text-black">
                                    <input type="date" class="form-control" id="birthdate" name="birthdate" placeholder="12/04/1870" value="{{ auth()->user()->birthdate }}">
                                    <label for="birthdate">Date de naissance</label>
                                </div>
                            </div>
                        </div>
                        <div class="mt-2 d-flex justify-content-center align-items-center">
                            <button class="btn btn-success bgPurpleButton">Modifier mes informations</button>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('script')
@endsection
