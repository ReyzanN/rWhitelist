@extends('layouts.public.app')

@section('title','Dashboard')

@section('content')
    <div class="container-fluid top10vh text-white">
        <div class="row-cols-12 d-flex flex-row d-flex justify-content-center">
            <div class="row col-3 bg-black rounded">
                <div class="row d-flex justify-content-center align-content-center">
                    <img src="/img/dashLogo.png" alt="logo" class="imgLogo">
                </div>
                <div class="row mt-3">
                    NAVIGATION
                </div>
            </div>
            <div class="row col-9 d-flex justify-content-around">
                <div class="col-3 bg-black rounded">BLOC 1</div>
                <div class="col-3 bg-black rounded">BLOC 2</div>
                <div class="col-3 bg-black rounded">BLOC 3</div>
            </div>
        </div>
    </div>
@endsection
