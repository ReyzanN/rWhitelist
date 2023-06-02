@extends('layouts.recruiters.app')

@section('title', 'QCM')

@section('content')
    <div class="container-fluid top10vh text-white">
        <div class="row-cols-12 d-flex flex-row d-flex justify-content-center">
            @include('layouts.recruiters.nav')
            <div class="row col-9 d-flex justify-content-around poppins">
                <div class="col-11 bg-black rounded d-flex overflow-auto">
                    <h1 class="mt-2">Gestion des QCM</h1>
                </div>
            </div>
        </div>
    </div>
@endsection
