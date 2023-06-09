@extends('layouts.recruiters.app')

@section('title','QCM Correction : '.$QCM->user()->discordUserName)

@section('content')
    <div class="container-fluid bg-black" id="CorrectionForm">
        <div class="row d-flex justify-content-center align-items-center text-white text-center">
            <h1 class="poppins mt-2">Correction du QCM de {{ $QCM->user()->discordUserName }}</h1>
            <p class="poppins">Score de : {{ $QCM->GetNoteForQCM() }} / {{ env('APP_WHITELIST_QCM_QUESTION') }}</p>
            @include('layouts.recruiters.errors')
        </div>
        <div>
            <input type="hidden" name="QCMId" value="{{ $QCM->id }}">
            @csrf
            @foreach($QuestionsList as $QL)
                <div class="d-flex justify-content-center align-items-center">
                    <hr class="w-75 text-white">
                </div>
                <div class="d-flex justify-content-center align-items-center mb-2">
                    <div class="col-2 d-flex justify-content-center align-items-center">
                        <a href="{{ route('qcm.correction.validateQuestion',[$QCM->id,$QL->id,1]) }}"><button class="btn btn-success" type="button">Valider la réponse</button></a>
                    </div>
                    <div class="col-2 d-flex justify-content-center align-items-center">
                        <a href="{{ route('qcm.correction.validateQuestion',[$QCM->id,$QL->id,0]) }}"><button class="btn btn-danger" type="button">Refuser la réponse</button></a>
                    </div>
                </div>
                <div class="row text-black">
                    <div class="mb-3 col-12">
                        <div class="mt-2 mb-2">
                            @if(!$QL->status)
                                <span class="badge text-bg-danger">Refusée</span>
                            @else
                                <span class="badge text-bg-success">Validé</span>
                            @endif
                        </div>
                        <div class="form-floating mb-3 fw-bold">
                            <input type="text" class="form-control" id="questionUpdate" placeholder="Type" value="{{ $QL->Question()->question }}" readonly>
                            <label for="question">Question</label>
                        </div>
                    </div>
                </div>
                <div class="row text-black">
                    <div class="mb-3 col-12">
                        <div class="form-floating">
                            <textarea class="form-control" placeholder="Entrez la réponse" id="answerUpdate" name="answer[{{ $QL->id }}]" style="height: 130px" maxlength="1000" readonly>{{ $QL->answer }}</textarea>
                            <label for="answer">Réponse du candidat</label>
                        </div>
                    </div>
                </div>
            @endforeach
            <div class="d-flex justify-content-center align-items-center">
                <hr class="w-75">
            </div>
            <div class="d-flex justify-content-center align-items-center">
                <a href="{{ route('qcm.correction.validate', $QCM->id) }}"><button class="btn btn-primary bgPurpleButton">J'ai fini !</button></a>
            </div>
        </div>
        <div class="d-flex justify-content-center align-items-center">
            <hr class="w-75 text-white">
        </div>
        <div class="d-flex justify-content-end align-content-end">
            <button class="btn btn-danger" onclick="self.close()">Quitter</button>
        </div>
    </div>
@endsection

@section('script')
    <script src="/js/ajax/Search.js"></script>
@endsection

