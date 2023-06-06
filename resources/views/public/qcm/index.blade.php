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
                    ///
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
@endsection

@section('script')
    <script src="/js/ajax/Search.js"></script>
    <script>
        function blank(){
            location.reload()
        }
    </script>
@endsection
