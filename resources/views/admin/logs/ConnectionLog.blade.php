@extends('layouts.admin.app')

@section('title','Admin - Connection Log')

@section('content')
    @include('layouts.admin.nav')

    <div class="container">

        <div class="row mt-5">
            @include('layouts.admin.errors')
        </div>

        <div class="row mt-5">
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
                @foreach($ConnectionLogs as $Log)
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
@endsection
