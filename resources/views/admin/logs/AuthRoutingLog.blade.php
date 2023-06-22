@extends('layouts.admin.app')

@section('title','Admin - Logs')

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
                    <th scope="col">URL</th>
                    <th scope="col">IP</th>
                    <th scope="col">Date & Heure</th>
                </tr>
                </thead>
                <tbody>
                @foreach($AuthRoutingLog as $Log)
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
@endsection
