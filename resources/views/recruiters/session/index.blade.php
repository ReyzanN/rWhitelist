@extends('layouts.recruiters.app')

@section('title','Gestion Sessions')

@section('content')
    <div class="container-fluid top10vh text-white">
        <div class="row-cols-12 d-flex flex-row d-flex justify-content-center">
            @include('layouts.recruiters.nav')
            <div class="row col-9 d-flex justify-content-around poppins">
                <div class="col-11 rounded d-flex flex-column">
                    <div class="row d-flex justify-content-center align-items-center mt-2">
                        <div class="col-4 d-flex justify-content-center align-items-center">
                            <button class="btn btn-primary bgPurpleButton text-uppercase" data-bs-toggle="modal" data-bs-target="#AddSession">Cree une session</button>
                        </div>
                    </div>
                    <div class="row d-flex justify-content-around mt-3">
                        @foreach($ActiveSession as $Session)
                            <div class="card bg-black text-white poppins" style="width: 25rem;">
                                <h3 class="mt-1 mx-1">{{ $Session->parseDateToStringWithDay($Session->SessionDate) }}</h3>
                                <div class="card-body">
                                    <div>
                                        <div class="row">
                                            <div class="col-8">
                                                <p class="mt-2">Date de la session :</p>
                                                <hr>
                                                <p class="mt-2">Nombre d'inscrit</p>
                                                <hr>
                                                <p class="mt-2">Thème</p>
                                                <hr>
                                                <p class="mt-2">Recruteurs disponible</p>
                                            </div>
                                            <div class="col-4 text-end">
                                                <p class="mt-2">{{ $Session->parseDateToTime($Session->SessionDate) }}</p>
                                                <hr>
                                                <p class="mt-2">{{ $Session->GetCountRegistrationCandidate() }} / {{ $Session->maxCandidate }}</p>
                                                <hr>
                                                <p class="mt-2">{{ $Session->theme }}</p>
                                                <hr>
                                                <p class="mt-2">{{ $Session->GetCountRegistrationRecruiters() }}</p>
                                            </div>
                                        </div>
                                        <div class="row d-flex justify-content-center align-items-center">
                                            <div class="col-6 d-flex justify-content-center align-items-center">
                                                @if($Session->RecruitersIsRegisteredForSession(auth()->user()->id))
                                                    <a href="{{ route('recruiters.session.unregister', $Session->id) }}"><button class="btn btn-success bgPurpleButton">Je participe plus</button></a>
                                                @else
                                                    <a href="{{ route('recruiters.session.register',$Session->id) }}"><button class="btn btn-success bgPurpleButton">Je participe</button></a>
                                                @endif
                                            </div>
                                            <div class="col-6 d-flex justify-content-center align-items-center">
                                                <button class="btn btn-success bgPurpleButton"><i class="bi bi-eye"></i></button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Add Session -->
    <div class="modal fade" id="AddSession" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="AddSessionLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content bg-black text-white">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="AddSessionLabel">Création de session</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('recruiters.sessions.add') }}" method="post">
                        @csrf
                        <div class="row flex-column">
                            <div>
                                <label for="SessionDate" class="form-label poppins">Date de la session</label>
                                <div class="input-group flex-nowrap poppins">
                                    <span class="input-group-text bg-black text-white border-secondary border-end-0" id="addon-calendar"><i class="bi bi-calendar"></i></span>
                                    <input type="datetime-local" class="form-control bg-black text-white border-secondary border-start-0" aria-describedby="addon-calendar" id="SessionDate" name="SessionDate">
                                </div>
                                <hr>
                            </div>
                            <div>
                                <label for="maxCandidate" class="form-label poppins">Nombre de slots</label>
                                <div class="input-group flex-nowrap poppins">
                                    <span class="input-group-text bg-black text-white border-secondary border-end-0" id="addon-person"><i class="bi bi-person"></i></span>
                                    <input type="number" class="form-control bg-black text-white border-secondary border-start-0" aria-describedby="addon-person" id="maxCandidate" name="maxCandidate">
                                </div>
                                <hr>
                            </div>
                            <div>
                                <label for="theme" class="form-label poppins">Thème <span class="opacity-50">(Laisser vide si général)</span></label>
                                <div class="input-group flex-nowrap poppins">
                                    <span class="input-group-text bg-black text-white border-secondary border-end-0" id="addon-chat"><i class="bi bi-chat"></i></span>
                                    <input type="text" class="form-control bg-black text-white border-secondary border-start-0" aria-describedby="addon-chat" id="theme" name="theme">
                                </div>
                                <hr>
                            </div>
                            <div class="d-flex justify-content-center align-items-center">
                                <button class="btn btn-success bgPurpleButton">Valider la session</button>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Annuler</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
@endsection
