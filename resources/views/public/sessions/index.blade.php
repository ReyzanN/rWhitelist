@extends('layouts.public.app')

@section('title','Sessions')

@section('content')
    <div class="container-fluid top10vh text-white">
        <div class="row-cols-12 d-flex flex-row d-flex justify-content-center">
            @include('layouts.public.nav')
            <div class="row col-9 d-flex justify-content-around poppins">
                <div class="col-11 bg-black rounded d-flex flex-column">
                    <div class="row">
                        <h1 class="mt-2">Session de recrutement</h1>
                        <div class="d-flex justify-content-center align-items-center">
                            <hr class="w-75">
                        </div>
                    </div>
                    <div class="row">
                        <p class="text-center">
                            Cette session a pour but, un entretien avec des recruteurs afin de définir si votre profil correspond à Classic, pas de panique, préparez votre background, une bonne lecture du règlement, de la logique et tout va bien se passer !
                            Vos chances ne sont pas limité ici, les recruteurs vont décider si vous méritez de vous représenter sinon, ça sera un refus définitif.
                        </p>
                        <p class="text-center">Vous ne pouvez vous inscrire qu'à une seule session en même temps, vous devez renseigner votre steamID et votre date de naissance dans "Mon Profil"</p>
                    </div>
                    <div class="d-flex justify-content-center align-items-center">
                        <button class="btn btn-success bgPurpleButton" data-bs-toggle="modal" data-bs-target="#ModalViewSession">Voir les sessions</button>
                    </div>
                    <div class="row mt-5 mb-2 d-flex justify-content-center align-items-center">
                        <hr class="w-25">
                    </div>
                    <div class="row">
                        <h3>Mes Sessions</h3>
                        <hr class="w-25 mx-2">
                        <div class="col-12 text-white">
                            <table class="table text-white" id="TableSessionCandidate">
                                <thead>
                                <tr>
                                    <th scope="col">Date de la Session</th>
                                    <th scope="col">Theme</th>
                                    <th scope="col">Background</th>
                                    <th scope="col">Résultat</th>
                                    <th scope="col"></th>
                                </tr>
                                </thead>
                                <tbody>
                                    @foreach(auth()->user()->GetRecruitmentRegistration() as $SessionCandidate)
                                        <td>{{ $SessionCandidate->parseDateToString($SessionCandidate->GetSession()->SessionDate) }}</td>
                                        <td>{{ $SessionCandidate->GetSession()->theme }}</td>
                                        <td><a href="{{ $SessionCandidate->backgroundURL }}" target="_blank"><button class="btn btn-success bgPurpleButton"><i class="bi bi-paperclip"></i></button></a></td>
                                        <td>
                                            @switch($SessionCandidate->result)
                                                @case(0)
                                                    <span class="badge text-bg-secondary">Session En cours</span>
                                                    @break
                                                @case(1)
                                                    <span class="badge text-bg-success">Session validée</span>
                                                    @break
                                                @case(2)
                                                    <span class="badge text-bg-warning">Refusé</span>
                                                    @break
                                                @case(3)
                                                    <span class="badge text-bg-danger">Refusé définitivement</span>
                                                    @break
                                            @endswitch
                                        </td>
                                        <td>
                                            @if(!$SessionCandidate->GetSession()->UserCanUnRegisterForSession())
                                                <button class="btn btn-warning" type="button" disabled>Me désinscrire</button>
                                            @else
                                                <a href="{{ route('candidate.sessions.unregister', $SessionCandidate->GetSession()->id) }}"><button class="btn btn-warning">Me désinscrire</button></a>
                                            @endif
                                        </td>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Session Modal -->
    <div class="modal modal-lg fade" id="ModalViewSession" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="ModalViewSessionLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content bg-black text-white">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="ModalViewSessionLabel">Liste des sessions disponibles</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <table class="table text-white text-center">
                        <thead>
                            <tr>
                                <th scope="col">Date de la Session</th>
                                <th scope="col">Theme</th>
                                <th scope="col">Nombre de place</th>
                                <th scope="col"></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($Session as $ActiveSession)
                                <tr>
                                    <td>{{ $ActiveSession->parseDateToString($ActiveSession->SessionDate) }}</td>
                                    <td>{{ $ActiveSession->theme }}</td>
                                    <td>{{ $ActiveSession->GetCountRegistrationCandidate() }} / {{ $ActiveSession->maxCandidate }}</td>
                                    @if(auth()->user()->CanApplyForAppointment() && !$ActiveSession->SessionIsFull())
                                        <td><button class="btn btn-success" data-bs-session="{{ $ActiveSession->id }}" data-bs-toggle="modal" data-bs-target="#ConformationSession"><i class="bi bi-check-circle"></i>&nbsp;M'inscrire</button></td>
                                    @else
                                        <td><button class="btn btn-success" disabled><i class="bi bi-check-circle"></i>&nbsp;M'inscrire</button></td>
                                    @endif
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Register -->
    <div class="modal fade" id="ConformationSession" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="ConformationSessionlabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content bg-black text-white">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="ConformationSessionlabel">Confirmation d'inscription</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form method="post" action="{{ route('candidate.sessions.register') }}">
                        @csrf
                        <input type="hidden" name="idSession" id="idSessionInput">
                        <div class="form-floating mb-3 text-black">
                            <input type="text" class="form-control" id="backgroundURL" name="backgroundURL" placeholder="docs.google.com" required>
                            <label for="backgroundURL">Lien Gdoc ( Background )</label>
                        </div>
                        <div class="mb-3 mt-3 d-flex justify-content-center align-items-center">
                            <button class="btn btn-success">M'inscrire</button>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" data-bs-toggle="modal" data-bs-target="#ModalViewSession">Retour</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
@endsection
