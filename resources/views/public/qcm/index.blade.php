@extends('layouts.public.app')

@section('title','QCM')


@section('content')
    <div class="container-fluid top10vh text-white">
        <div class="row-cols-12 d-flex flex-row d-flex justify-content-center">
            @include('layouts.public.nav')
            <div class="row col-9 d-flex justify-content-around poppins">
                <div class="col-11 bg-black rounded d-flex flex-column">
                    <div class="row">
                        <h1 class="mt-2">Questionnaire</h1>
                        <p><span class="badge rounded-pill text-bg-light">Il vous reste : {{ $QCMChance }} chance(s)</span></p>
                        <div class="d-flex justify-content-center align-items-center">
                            <hr class="w-75">
                        </div>
                    </div>
                    <div class="row">
                        <p class="text-center">Le questionnaire Classic n’est validé seulement qu’en obtenant un ratio de {{ env('APP_WHITELIST_QCM_SCORE_MINI') }} réponses correctes sur l’ensemble de celui-ci. Si il est échoué vous avez la possibilité de le repasser jusqu'à {{ env('APP_WHITELIST_QCM_ATTEMPT') }} fois maximum.</p>
                        <div class="d-flex justify-content-center align-items-center">
                            <button class="btn btn-primary text-uppercase bgPurpleButton" @if(!$CanDoQCM) disabled @endif data-bs-toggle="modal" data-bs-target="#QCM" onclick="SearchAjax('','{{ route('qcm.candidate.getQCM.ajax') }}','QCMModalCandidate','{{ csrf_token() }}')">commencer !</button>
                        </div>
                    </div>
                    <div class="row mt-5 mb-2 d-flex justify-content-center align-items-center">
                        <hr class="w-25">
                    </div>
                    <div class="row">
                        <h3>Mes QCM</h3>
                        <hr class="w-25 mx-2">
                        <div class="col-12 text-white">
                            <table class="table text-white">
                                <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Type</th>
                                    <th scope="col">Status</th>
                                    <th scope="col">Corrigé</th>
                                    <th scope="col">Note</th>
                                    <th scope="col">Fait le</th>
                                    <th scope="col">Reprendre</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($OldQCM as $OQ)
                                    <tr>
                                        <th scope="row">{{ $OQ->id }}</th>
                                        <th scope="row"><span class="badge rounded-pill text-bg-secondary">Normal / Seconde Chance</span></th>
                                        <td>
                                            @if(!$OQ->active)
                                                <span class="badge rounded-pill text-bg-success">Envoyé</span>
                                            @else
                                                <span class="badge rounded-pill text-bg-danger">Non terminé</span>
                                            @endif
                                        </td>
                                        <td>
                                            @if(!$OQ->graded)
                                                <span class="badge rounded-pill text-bg-warning">Non corrigé</span>
                                            @else
                                                <span class="badge rounded-pill text-bg-success">Corrigé</span>
                                            @endif
                                        </td>
                                        <td>
                                            @if($OQ->graded)
                                                {{ $QO->GetNoteForQCM() }} / {{ env('APP_WHITELIST_QCM_QUESTION') }}
                                            @else
                                                <span class="badge rounded-pill text-bg-secondary">Non corrigé</span>
                                            @endif
                                        </td>
                                        <td>{{ $OQ->parseDateToString($OQ->created_at) }}</td>
                                        <td>
                                            @if($OQ->active)
                                                <button class="btn btn-primary bgPurpleButton" data-bs-toggle="modal" data-bs-target="#QCM" onclick="SearchAjax('{{ $OQ->id  }}','{{ route('qcm.candidate.continue.ajax') }}','QCMModalCandidate','{{ csrf_token() }}')"><i class="bi bi-eye"></i></button>
                                            @else
                                                <span class="badge rounded-pill text-bg-success">Envoyé</span>
                                            @endif
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


    <!-- QCM Modal -->
    <div class="modal fade" id="QCM" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="QCMLabel" aria-hidden="true">
        <div class="modal-dialog modal-fullscreen">
            <div class="modal-content bg-black text-white poppins">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="QCMLabel">
                        Question de : {{ auth()->user()->discordUserName }}
                    </h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" id="QCMModalCandidate">
                    <div class="spinner-border text-success" role="status">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal" data-bs-toggle="modal" data-bs-target="#QCMConfirm">Quitter</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Confirm Modal -->
    <div class="modal fade" id="QCMConfirm" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="QCMConfirm" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content bg-black text-white poppins">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="QCMConfirm">
                        Êtes vous sûr ?
                    </h1>
                </div>
                <div class="modal-body" id="QCMModalCandidate">
                    <div class="alert alert-danger" role="alert">
                        Pour éviter toute forme de triche votre progression ne sera pas sauvegardé, vous recommencerait avec les mêmes questions, mais sans vos réponses.
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal" onclick="blank()">Oui je pars !</button>
                    <button type="button" class="btn btn-success" data-bs-dismiss="modal" data-bs-toggle="modal" data-bs-target="#QCM">Non je finis !</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal View -->
    <div class="modal fade" id="QCMView" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="QCMView" aria-hidden="true">
        <div class="modal-dialog modal-fullscreen">
            <div class="modal-content bg-black text-white poppins">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="QCMView">
                        Question de : {{ auth()->user()->discordUserName }}
                    </h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" id="QCMModalCandidateView">
                    <div class="spinner-border text-success" role="status">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script src="/js/ajax/Search.js"></script>
    <script>
        function blank(){
            location.reload()
        }
    </script>
@endsection
