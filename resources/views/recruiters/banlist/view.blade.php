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
                            <button class="btn btn-primary bgPurpleButton" data-bs-toggle="modal" data-bs-target="#QFTadd"><i class="bi bi-plus-circle"></i>&nbsp;Ajouter un ban</button>
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
                                            <button class="btn btn-primary bgPurpleButton" onclick="SearchAjax('{{ $B->id }}','{{ route('qcm.questionFirstChance.ajax.update') }}','QFTUpdateModal','{{ csrf_token() }}')" data-bs-toggle="modal" data-bs-target="#QFTUpdate"><i class="bi bi-eye"></i></button>
                                            <a href="{{ route('qcm.questionFirstChance.remove',$B->id) }}" ><button class="btn btn-primary bgPurpleButton"><i class="bi bi-trash"></i></button></a>
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
@endsection
