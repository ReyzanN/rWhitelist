@extends('layouts.recruiters.app')

@section('title','Gestion Candidat')

@section('content')
    <div class="container-fluid top10vh text-white">
        <div class="row-cols-12 d-flex flex-row d-flex justify-content-center">
            @include('layouts.recruiters.nav')
            <div class="row col-9 d-flex justify-content-around poppins">
                <div class="col-11 bg-black rounded d-flex flex-column">
                    <div class="row">
                        <h1 class="mt-2">Liste des candidats</h1>
                    </div>
                    <div class="row d-flex">
                        <div class="d-flex flex-row justify-content-around align-items-center">
                            <p><span class="badge text-bg-light">Nombre de candidat : 12</span></p>
                            <p><span class="badge text-bg-light">Nombre de personne WL : 0</span></p>
                        </div>
                        <hr class="mx-2 w-25">
                    </div>
                    <div class="row mt-2">
                        <div class="col-12">
                            <table class="table text-white text-center" id="CandidateTable">
                                <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">ID Compte Discord</th>
                                    <th scope="col">Nom Discord</th>
                                    <th scope="col">Status QCM</th>
                                    <th scope="col">Status Entretient</th>
                                    <th scope="col">Status WL</th>
                                    <th scope="col"></th>
                                </tr>
                                </thead>
                                <tbody class="text-center">
                                @foreach($Candidate as $C)
                                    <tr>
                                        <th scope="row">{{ $C->id }}</th>
                                        <td>{{ $C->discordAccountId }}</td>
                                        <td>{{ $C->discordUserName }}</td>
                                        <td>
                                            @if($C->qcm)
                                                <i class="bi bi-check-circle" style="color: green"></i>
                                            @else
                                                <i class="bi bi-question-circle" style="color: orange"></i>
                                            @endif
                                        </td>
                                        <td>
                                            @if($C->appointement)
                                                <i class="bi bi-check-circle" style="color: green"></i>
                                            @else
                                                <i class="bi bi-question-circle" style="color: orange"></i>
                                            @endif
                                        </td>
                                        <td>
                                            @if($C->isWL())
                                                <i class="bi bi-check-circle" style="color: green"></i>
                                            @else
                                                <i class="bi bi-question-circle" style="color: orange"></i>
                                            @endif
                                        </td>
                                        <td>
                                            <button class="btn btn-primary bgPurpleButton" data-bs-toggle="modal" data-bs-target="#ModalUsers" onclick="SearchAjax('{{ $C->id }}','{{ route('recruiters.candidate.view.ajax') }}','ModalInfoCandidate','{{ csrf_token() }}')"><i class="bi bi-eye"></i></button>
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

    <!-- Modal Users -->
    <div class="modal fade" id="ModalUsers" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="ModalUsersLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg bg-black">
            <div class="modal-content bg-black text-white">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="ModalUsersLabel">Détail de l'utilisateur</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" id="ModalInfoCandidate">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Fermer</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script src="/js/ajax/Search.js"></script>
@endsection
