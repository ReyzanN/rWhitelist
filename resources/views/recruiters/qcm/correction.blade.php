@extends('layouts.recruiters.app')

@section('title', 'Correction QCM')

@section('content')
    <div class="container-fluid top10vh text-white">
        <div class="row-cols-12 d-flex flex-row d-flex justify-content-center">
            @include('layouts.recruiters.nav')
            <div class="row col-9 d-flex justify-content-around poppins">
                <div class="col-11 bg-black rounded d-flex flex-column">
                    <div class="row">
                        <h1 class="mt-2">Correction QCM</h1>
                    </div>
                    <div class="row d-flex">
                        <div class="d-flex flex-row justify-content-around align-items-center">
                            <p><span class="badge text-bg-light">Nombre de correction en attente : {{ $QCMPendingCount }}</span></p>
                        </div>
                        <hr class="mx-2 w-25">
                    </div>
                    <div class="row mt-2">
                        <table class="table text-white text-center" id="QCMPendingList">
                            <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Pseudo</th>
                                <th scope="col">Commencé le</th>
                                <th scope="col">Envoyé le</th>
                                <th scope="col"></th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($QCMCandidate as $QCM)
                                <tr>
                                    <th scope="row">{{ $QCM->id }}</th>
                                    <td>{{ $QCM->user()->discordUserName }}</td>
                                    <td>{{ $QCM->parseDateToString($QCM->created_at) }}</td>
                                    <td>{{ $QCM->parseDateToString($QCM->updated_at) }}</td>
                                    <td>
                                        <a href="{{ route('qcm.beginCorrection',$QCM->id) }}" target="_blank"><button class="btn btn-primary bgPurpleButton"><i class="bi bi-eye"></i></button></a>
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

    <!-- Modal -->
    <div class="modal fade" id="CorrectionModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="CorrectionModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-fullscreen">
            <div class="modal-content bg-black text-white">
                <div class="modal-header text-white">
                    <h1 class="modal-title fs-5" id="CorrectionModalLabel">Correction de QCM</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body text-white" id="ModalCorrection">
                    ...
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Quitter</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script src="/js/ajax/search.js"></script>
@endsection
