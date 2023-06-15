<div class="row">
    <div class="col-6">
        <div class="input-group mb-3">
            <span class="input-group-text" id="addon1"><i class="bi bi-person"></i></span>
            <input type="text" class="form-control" aria-describedby="addon1" value="{{ $Candidate->discordUserName }}" readonly>
        </div>
    </div>
    <div class="col-6">
        <div class="input-group mb-3">
            <span class="input-group-text" id="addon2"><i class="bi bi-discord"></i></span>
            <input type="text" class="form-control" aria-describedby="addon2" value="{{ $Candidate->discordAccountId }}" readonly>
        </div>
    </div>
</div>

<div class="row mt-2 mb-2"></div>

<div class="row">
    <div class="col-6">
        <div class="input-group mb-3">
            <span class="input-group-text" id="addon3"><i class="bi bi-steam"></i></span>
            <input type="text" class="form-control" aria-describedby="addon3" value="{{ $Candidate->steamId }}" readonly>
        </div>
    </div>
    <div class="col-6">
        <div class="input-group mb-3">
            <span class="input-group-text" id="addon4"><i class="bi bi-clock"></i></span>
            <input type="text" class="form-control" aria-describedby="addon4" value="{{ $Candidate->parseDateToString($Candidate->lastConnection) }}" readonly>
        </div>
    </div>
</div>

<div class="row mt-2 mb-2"></div>

<div class="row">
    <div class="col-6">
        <div class="input-group mb-3">
            <span class="input-group-text" id="addon3">Date de création</span>
            <input type="text" class="form-control" aria-describedby="addon3" value="{{ $Candidate->parseDateToString($Candidate->created_at) }}" readonly>
        </div>
    </div>
    <div class="col-6">
        <div class="input-group mb-3">
            <span class="input-group-text" id="addon4">Date de modification</span>
            <input type="text" class="form-control" aria-describedby="addon4" value="{{ $Candidate->parseDateToString($Candidate->created_at) }}" readonly>
        </div>
    </div>
</div>

<div class="row mt-2 mb-2"></div>

<div class="row d-flex justify-content-center align-items-center">
    <div class="col-6">
        <div class="input-group mb-3">
            <span class="input-group-text" id="addon3">Date de naissance</span>
            <input type="text" class="form-control" aria-describedby="addon3" value="{{ $Candidate->parseDateToString($Candidate->birthdate) }}" readonly>
        </div>
    </div>
</div>

<div class="row mt-2 mb-2"></div>

<div class="row">
    <div class="col-12">
        <p>QCM Du Candidat</p>
        <hr>
        <table class="table text-white text-center">
            <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">État</th>
                <th scope="col">Date de réalisation</th>
                <th scope="col">Score</th>
                <th scope="col">Jugé par</th>
                <th scope="col"></th>
            </tr>
            </thead>
            <tbody class="text-center">
            @foreach($Candidate->QCMApplication() as $QCMApplication)
            <tr>
                <th scope="row">{{ $QCMApplication->id }}</th>
                <td>
                    @if($QCMApplication->graded)
                    <span class="badge text-bg-success">Corrigé</span>
                    @elseif($QCMApplication->active)
                    <span class="badge text-bg-danger">Non envoyé</span>
                    @else
                    <span class="badge text-bg-warning">En attente de correction</span>
                    @endif
                </td>
                <td>{{ $QCMApplication->parseDateToString($QCMApplication->updated_at) }}</td>
                <td>{{ $QCMApplication->GetNoteForQCM() }}</td>
                <td>{{ $QCMApplication->GetGradedBy()->discordUserName }}</td>
                <td><a href="{{ route('qcm.beginCorrection',$QCMApplication->id) }}" target="_blank"><button class="btn btn-primary bgPurpleButton"><i class="bi bi-eye"></i></button></a></td>
            </tr>
            @endforeach
            </tbody>
        </table>
    </div>
</div>

<div class="row mt-2 mb-2"></div>

<div class="row">
    <div class="col-12">
        <p>Session Du Candidat</p>
        <hr>
        <table class="table text-white text-center">
            <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">Date</th>
                <th scope="col">Jugé par</th>
                <th scope="col">Background</th>
                <th scope="col">Présent</th>
                <th scope="col">Résultat</th>
            </tr>
            </thead>
            <tbody>
            @foreach($Candidate->GetRecruitmentRegistration() as $SessionCandidate)
                <tr>
                    <th scope="row">{{ $SessionCandidate->GetSession()->id }}</th>
                    <td>{{ $SessionCandidate->GetSession()->parseDateToString($SessionCandidate->GetSession()->SessionDate) }}</td>
                    <td>
                        @if($SessionCandidate->GetValidatedBy())
                            {{ $SessionCandidate->GetValidatedBy()->discordUserName }}
                        @else
                            Session en cours
                        @endif
                    </td>
                    <td><a href="{{ $SessionCandidate->backgroundURL }}" target="_blank"><button class="btn btn-success bgPurpleButton"><i class="bi bi-paperclip"></i></button></a></td>
                    <td>
                        @if(!$SessionCandidate->present)
                            <span class="badge text-bg-danger">Non</span>
                        @else
                            <span class="badge text-bg-success">Oui</span>
                        @endif
                    </td>
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
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
</div>

<div class="row mt-2 mb-2"></div>

<div class="row">
    <div class="col-12">
        <p>Bannissement Du Candidat</p>
        <hr>
        <table class="table text-white">
            <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">Raison</th>
                <th scope="col">Date d'expiration</th>
                <th scope="col">Date de ban</th>
                <th scope="col">Date de modification</th>
            </tr>
            </thead>
            <tbody>
            @foreach($Candidate->GetBan() as $Ban)
            <tr>
                <th scope="row">{{ $Ban->id }}</th>
                <td>{{ $Ban->reason }}</td>
                <td>{{ $Ban->parseDateToString($Ban->expiration) }}</td>
                <td>{{ $Ban->parseDateToString($Ban->created_at) }}</td>
                <td>{{ $Ban->parseDateToString($Ban->updated_at) }}</td>
            </tr>
            @endforeach
            </tbody>
        </table>
    </div>
</div>

<div class="row mt-2 mb-2">
    <hr>
</div>

<div class="row">
    <div class="col-12">
        <form action="{{ route('recruiters.candidate.update.note') }}" method="post">
            @csrf
            <input type="hidden" name="id" id="id" value="{{ $Candidate->id }}">
            <div class="form-floating text-black">
                <textarea class="form-control" placeholder="Note" id="note" name="note" style="height: 100px">{{ $Candidate->note }}</textarea>
                <label for="note">Note</label>
            </div>
            <div class="mb-2 mt-2">
                <button class="btn btn-success">Ajouter la note</button>
            </div>
        </form>
    </div>
</div>
