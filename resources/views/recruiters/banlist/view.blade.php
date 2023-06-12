@extends('layouts.recruiters.app')

@section('title','Liste des bans')

@section('content')
    <div class="container-fluid top10vh text-white">
        <div class="row-cols-12 d-flex flex-row d-flex justify-content-center">
            @include('layouts.recruiters.nav')
            <div class="row col-9 d-flex justify-content-around poppins">
                <div class="col-11 bg-black rounded d-flex flex-column">
                    <div class="row">
                        <h1 class="mt-2">Liste des bans</h1>
                    </div>
                    <div class="row d-flex">
                        <div class="d-flex flex-row justify-content-around align-items-center">
                            <p><span class="badge text-bg-light">Nombre ban : {{ $BanCount }}</span></p>
                        </div>
                        <div class="mb-2">
                            <button class="btn btn-primary bgPurpleButton" data-bs-toggle="modal" data-bs-target="#ModalAddBan"><i class="bi bi-plus-circle"></i>&nbsp;Ajouter un ban</button>
                        </div>
                        <hr class="mx-2 w-25">
                    </div>
                    <div class="row mt-2">
                        <div class="col-12">
                            <table class="table text-white" id="BanList">
                                <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Discord Compte ID</th>
                                    <th scope="col">Raison</th>
                                    <th scope="col">Expiration</th>
                                    <th scope="col">Date de ban</th>
                                    <th scope="col">Dernière modification</th>
                                    <th scope="col"></th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($BanList as $B)
                                    <tr>
                                        <th scope="row">{{ $B->id }}</th>
                                        <td>{{ $B->discordAccountId }}</td>
                                        <td>{{ $B->reason }}</td>
                                        <td>
                                            @if($B->expiration)
                                                <span class="badge text-bg-warning">{{ $B->parseDateToString($B->expiration) }}</span>
                                            @else
                                                <span class="badge text-bg-danger">Jamais</span>
                                            @endif
                                        </td>
                                        <td>{{ $B->parseDateToString($B->created_at) }}</td>
                                        <td>{{ $B->parseDateToString($B->updated_at) }}</td>
                                        <td>
                                            <a href="{{ route('recruiters.ban.remove', $B->id) }}" ><button class="btn btn-primary bgPurpleButton"><i class="bi bi-trash"></i></button></a>
                                            <button class="btn btn-primary bgPurpleButton" data-bs-toggle="modal" data-bs-target="#ModalUpdateBan" data-bs-id="{{ $B->id }}" data-bs-reason="{{ $B->reason }}" data-bs-expiration="{{ $B->expiration }}"><i class="bi bi-pencil"></i></button>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Add Ban -->
    <div class="modal fade" id="ModalAddBan" tabindex="-1" aria-labelledby="ModalUpdateBanLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content bg-black text-white">
                <div class="modal-header bg-black text-white">
                    <h1 class="modal-title fs-5" id="ModalUpdateBanLabel">Ajouter une bannissement</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body bg-black text-white">
                    <form action="{{ route('recruiters.ban.add') }}" method="post" class="text-black">
                        @csrf
                        <div class="form-floating mb-3">
                            <input type="text" class="form-control" id="discordAccountId" name="discordAccountId" placeholder="Le cœur a ses raisons que la raison ignore" value="">
                            <label for="discordAccountId">Compte Discord</label>
                        </div>

                        <div class="form-floating mb-3">
                            <input type="text" class="form-control" id="ReasonBanAdd" name="reason" placeholder="Le cœur a ses raisons que la raison ignore" value="">
                            <label for="ReasonBanAdd">Raison</label>
                        </div>

                        <div class="form-floating mb-3">
                            <input type="datetime-local" class="form-control" id="ExpirationBanAdd" name="expiration" value="">
                            <label for="ExpirationBanAdd">Expiration</label>
                        </div>

                        <div class="mb-2 mt-2">
                            <button class="btn btn-warning">Modifier</button>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Fermer</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Update Ban -->
    <div class="modal fade" id="ModalUpdateBan" tabindex="-1" aria-labelledby="ModalUpdateBanLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content bg-black text-white">
                <div class="modal-header bg-black text-white">
                    <h1 class="modal-title fs-5" id="ModalUpdateBanLabel">Modifier une bannissement</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body bg-black text-white">
                    <form action="{{ route('recruiters.ban.update') }}" method="post" class="text-black">
                        @csrf
                        <input type="hidden" name="id" id="idBan" value="">

                        <div class="form-floating mb-3">
                            <input type="text" class="form-control" id="ReasonBan" name="reason" placeholder="Le cœur a ses raisons que la raison ignore" value="">
                            <label for="ReasonBan">Raison</label>
                        </div>

                        <div class="form-floating mb-3">
                            <input type="datetime-local" class="form-control" id="ExpirationBan" name="expiration" value="">
                            <label for="ExpirationBan">Expiration</label>
                        </div>

                        <div class="mb-2 mt-2">
                            <button class="btn btn-warning">Modifier</button>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Fermer</button>
                </div>
            </div>
        </div>
    </div>
@endsection
