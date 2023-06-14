@extends('layouts.recruiters.app')

@section('title','Session de recrutement')

@section('content')
    <div class="container-fluid bg-blackOpacity75" id="ViewSession">
        <div class="row d-flex justify-content-center align-items-center text-white text-center">
            <h1 class="poppins mt-3">Session de recrutement</h1>
            <div class="d-flex justify-content-center align-items-center">
                <hr class="w-75">
            </div>
            <div id="MessageAjax"></div>
            @include('layouts.recruiters.errors')
        </div>
        <div class="row text-white poppins">
            <h4><span class="badge text-bg-light">Information de la Session</span></h4>
            <div class="row mt-2 d-flex justify-content-center align-items-center">
                <div class="col-6 d-flex justify-content-center align-items-center">
                    <ul class="list-group list-group-flush rounded-2 fw-bold">
                        <li class="list-group-item">Numéro de Session :</li>
                        <li class="list-group-item">Date de la session :</li>
                        <li class="list-group-item">Nombre d'inscrit :</li>
                        <li class="list-group-item">Thème de la session :</li>
                        <li class="list-group-item">Nombre de recruteur présent :</li>
                    </ul>
                </div>
                <div class="col-6 d-flex justify-content-center align-items-center">
                    <ul class="list-group list-group-flush rounded-2">
                        <li class="list-group-item">{{ $SessionInformation->id }}</li>
                        <li class="list-group-item">{{ $SessionInformation->parseDateToString($SessionInformation->SessionDate) }}</li>
                        <li class="list-group-item">{{ $SessionInformation->GetCountRegistrationCandidate() }}</li>
                        <li class="list-group-item">{{ $SessionInformation->theme }}</li>
                        <li class="list-group-item">{{ $SessionInformation->GetCountRegistrationRecruiters() }}</li>
                    </ul>
                </div>
            </div>
        </div>

        <div class="row mt-2 mb-2"></div>

        <div class="row poppins">
            <div class="accordion" id="accordionExample">
                <div class="accordion-item">
                    <h2 class="accordion-header">
                        <button class="accordion-button collapsed fw-bold" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="false" aria-controls="collapseOne">
                            <i class="bi bi-person"></i>&nbsp;Liste des recruteurs présent
                        </button>
                    </h2>
                    <div id="collapseOne" class="accordion-collapse collapse" data-bs-parent="#accordionExample">
                        <div class="accordion-body">
                            <ul class="list-group">
                                @foreach($Recruiters as $Re)
                                    @if($Re->avatar)
                                        <li class="list-group-item"><img src="https://cdn.discordapp.com/avatars/{{ $Re->GetUser()->discordAccountId }}/{{ $Re->avatar }}" class="rounded-circle border" width="3%">&nbsp;{{ $Re->GetUser()->discordUserName }}</li>
                                    @else
                                        <li class="list-group-item">{{ $Re->GetUser()->discordUserName }}</li>
                                    @endif
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="accordion-item">
                    <h2 class="accordion-header">
                        <button class="accordion-button collapsed fw-bold" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                            <i class="bi bi-person-vcard"></i>&nbsp;Liste des candidats pour la session
                        </button>
                    </h2>
                    <div id="collapseTwo" class="accordion-collapse collapse" data-bs-parent="#accordionExample">
                        <div class="accordion-body">
                            <div class="mt-1 mb-1">
                                <button class="btn btn-success bgPurpleButton" onclick="SearchAjax('{{ $SessionInformation->id }}','{{ route('recruiters.session.candidate.call.all.ajax') }}','MessageAjax', '{{ csrf_token() }}')">Appeler les candidats</button>
                            </div>
                            <table class="table text-black" id="CandidateListeForSession">
                                <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Pseudo</th>
                                    <th scope="col">DiscordId</th>
                                    <th scope="col">Résultat</th>
                                    <th scope="col">Validé par</th>
                                    <th scope="col">Background</th>
                                    <th scope="col"></th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($SessionInformation->GetCandidateRegistration() as $Candidate)
                                    <tr>
                                        <th scope="row">{{ $Candidate->GetUser()->id }}</th>
                                        <td>{{ $Candidate->GetUser()->discordUserName }}</td>
                                        <td>{{ $Candidate->GetUser()->discordAccountId }}</td>
                                        <td>
                                            @if($Candidate->result == null)
                                                <span class="badge text-bg-light">En attente</span>
                                            @elseif($Candidate->result == 1)
                                                <span class="badge text-bg-success">Accepté</span>
                                            @elseif($Candidate->result == 2)
                                                <span class="badge text-bg-warning">Refus</span>
                                            @elseif($Candidate->result == 3)
                                                <span class="badge text-bg-danger">Refus définitif</span>
                                            @endif
                                        </td>
                                        <td>
                                            @if($Candidate->GetValidatedBy())
                                                {{ $Candidate->GetValidatedBy()->discordUserName }}
                                            @else
                                                <span>/</span>
                                            @endif

                                        </td>
                                        <td><a href="{{ $Candidate->backgroundURL }}" target="_blank"><button class="btn btn-primary bgPurpleButton"><i class="bi bi-paperclip"></i></button></a></td>
                                        <td>
                                            @if(!$Candidate->result)
                                                <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#ValidUser" data-bs-link="{{ route('recruiters.sessions.validateCandidate',[$Candidate->idSession, $Candidate->GetUser()->id]) }}"><i class="bi bi-check"></i></button>
                                                <button class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#RefusedUser" data-bs-link="{{ route('recruiters.sessions.refusedCandidate',[$Candidate->idSession, $Candidate->GetUser()->id]) }}"><i class="bi bi-question-lg"></i></button>
                                                <button class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#PermaRefused" data-bs-link="{{ route('recruiters.sessions.permanentRefused',[$Candidate->idSession, $Candidate->GetUser()->id]) }}"><i class="bi bi-x"></i></button>
                                                <button class="btn btn-danger" onclick="SearchAjax('{{ $Candidate->GetUser()->discordAccountId }}','{{ route('recruiters.session.candidate.call.ajax') }}','MessageAjax', '{{ csrf_token() }}')"><i class="bi bi-bell"></i></button>
                                                <button class="btn btn-primary bgPurpleButton" data-bs-toggle="modal" data-bs-target="#ModalUsers" onclick="SearchAjax('{{ $Candidate->GetUser()->id }}','{{ route('recruiters.session.view.candidate.ajax') }}','ModalInfoCandidate','{{ csrf_token() }}')"><i class="bi bi-eye"></i></button>
                                            @else
                                                <button class="btn btn-primary bgPurpleButton" data-bs-toggle="modal" data-bs-target="#ModalUsers" onclick="SearchAjax('{{ $Candidate->GetUser()->id }}','{{ route('recruiters.session.view.candidate.ajax') }}','ModalInfoCandidate','{{ csrf_token() }}')"><i class="bi bi-eye"></i></button>
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

        <div class="row mt-2 mb-2"></div>

        <div class="row d-flex justify-content-center align-items-center">
            <div class="d-flex justify-content-center align-items-center">
                <button class="btn btn-success bgPurpleButton" data-bs-toggle="modal" data-bs-target="#EndSession">La session est terminée</button>
            </div>
        </div>

        <div class="d-flex justify-content-end align-content-end mt-5">
            <button class="btn btn-danger" onclick="self.close()">Quitter</button>
        </div>
    </div>


    <!-- Modal User -->
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

    <!-- Confirm end session -->
    <div class="modal fade" id="EndSession" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="EndSessionlabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="EndSessionlabel">Confirmation fin de session</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="alert alert-danger" role="alert">
                        Attention cette opération est non réversible terminer la session passera tous les candidats au status d'échoué, ils pourront se représenter néanmoins ils auront une absence.
                    </div>
                    <div class="d-flex justify-content-center align-items-center">
                        <a href="{{ route('recruiters.terminateSession',$SessionInformation->id) }}"><button class="btn btn-success bgPurpleButton">Terminer la session</button></a>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal -->
        <!-- Valid -->
        <div class="modal fade" id="ValidUser" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="ValidUserLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="ValidUserLabel">Valider l'entretient</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="alert alert-success" role="alert">
                            Si vous validez cette personne elle obtiendra le grade whitelist, c'est votre dernier mot ?
                        </div>
                        <div class="d-flex justify-content-center align-items-center">
                            <a href="" id="ValidUserLink"><button class="btn btn-success">Valider l'entretient</button></a>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Refused -->
        <div class="modal fade" id="RefusedUser" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="RefusedUserlabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="RefusedUserlabel">Refuser l'entretient</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="alert alert-warning" role="alert">
                            Cette personne sera refusée, néanmoins elle aura la possibilité de retenter sa chance.
                        </div>
                        <div class="d-flex justify-content-center align-items-center">
                            <a href="" id="RefusedLink"><button class="btn btn-warning">Refuser l'entretient</button></a>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                    </div>
                </div>
            </div>
        </div>

    <!-- Perma Refused -->
    <div class="modal fade" id="PermaRefused" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="PermaRefusedLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="PermaRefusedLabel">Refuser de façon permanante l'entretient</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="alert alert-danger" role="alert">
                        Cette personne sera refusée, elle ne pourra plus tenter sa chance.
                    </div>
                    <div class="d-flex justify-content-center align-items-center">
                        <a href="" id="PermanentRefusedLink"><button class="btn btn-danger">Refuser définitivement</button></a>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script src="/js/ajax/Search.js"></script>
@endsection
