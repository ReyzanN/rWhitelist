@extends('layouts.admin.app')

@section('title','Admin - Auth Routing Log')

@section('content')
    @include('layouts.admin.nav')

    <div class="container">

        <div class="row mt-5">
            @include('layouts.admin.errors')
        </div>

        <div class="row mt-3 mb-3">
            <div class="col-6">
                <ul class="list-group list-group-flush fw-bold">
                    <li class="list-group-item">Discord Account ID :</li>
                    <li class="list-group-item">Discord Account Name :</li>
                    <li class="list-group-item">Last Connection :</li>
                    <li class="list-group-item">Created At :</li>
                </ul>
            </div>
            <div class="col-6">
                <ul class="list-group list-group-flush">
                    <li class="list-group-item">{{ $User->discordAccountId }}</li>
                    <li class="list-group-item">{{ $User->discordUserName }}</li>
                    <li class="list-group-item">{{ $User->lastConnection }}</li>
                    <li class="list-group-item">{{ $User->created_at }}</li>
                </ul>
            </div>
        </div>

        <div class="row mt-3">
            <div class="accordion" id="accordionExample">
                <div class="accordion-item">
                    <h2 class="accordion-header">
                        <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                            Connection Log
                        </button>
                    </h2>
                    <div id="collapseOne" class="accordion-collapse collapse show" data-bs-parent="#accordionExample">
                        <div class="accordion-body">
                            <table class="table" id="AuthRoutingLog">
                                <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">DiscordAccountId</th>
                                    <th scope="col">IP</th>
                                    <th scope="col">Résultat</th>
                                    <th scope="col">Date & Heure</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($User->GetConnectionLog() as $Log)
                                    <tr>
                                        <th scope="row">{{ $Log->id }}</th>
                                        <td>{{ $Log->discordAccountId }}</td>
                                        <td>{{ $Log->ip }}</td>
                                        <td>
                                            @if($Log->result)
                                                <span class="badge text-bg-success">Ok</span>
                                            @else
                                                <span class="badge text-bg-danger">Échec</span>
                                            @endif
                                        </td>
                                        <td>{{ $Log->created_at }}</td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="accordion-item">
                    <h2 class="accordion-header">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                            Action Log
                        </button>
                    </h2>
                    <div id="collapseTwo" class="accordion-collapse collapse" data-bs-parent="#accordionExample">
                        <div class="accordion-body">
                            <table class="table" id="ActionLog">
                                <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">DiscordAccountId</th>
                                    <th scope="col">Controller</th>
                                    <th scope="col">Action</th>
                                    <th scope="col">Résultat</th>
                                    <th scope="col">Date & Heure</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($User->GetActionLog() as $Log)
                                    <tr>
                                        <th scope="row">{{ $Log->id }}</th>
                                        <td>{{ $Log->discordAccountId }}</td>
                                        <td>{{ $Log->controller }}</td>
                                        <td>{{ $Log->type }}</td>
                                        <td>{{ $Log->result }}</td>
                                        <td>{{ $Log->created_at }}</td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="accordion-item">
                    <h2 class="accordion-header">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                            Routing Log
                        </button>
                    </h2>
                    <div id="collapseThree" class="accordion-collapse collapse" data-bs-parent="#accordionExample">
                        <div class="accordion-body">
                            <table class="table" id="RoutingLog">
                                <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">DiscordAccountId</th>
                                    <th scope="col">URL</th>
                                    <th scope="col">IP</th>
                                    <th scope="col">Date & Heure</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($User->GetRoutingLog() as $Log)
                                    <tr>
                                        <th scope="row">{{ $Log->id }}</th>
                                        <td>{{ $Log->discordAccountId }}</td>
                                        <td>{{ $Log->url }}</td>
                                        <td>{{ $Log->ip }}</td>
                                        <td>{{ $Log->created_at }}</td>
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
