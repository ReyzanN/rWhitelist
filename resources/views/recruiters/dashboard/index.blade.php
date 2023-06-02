@extends('layouts.recruiters.app')

@section('title', 'Recruiters Dashboard')

@section('content')
    <div class="container-fluid top10vh text-white">
        <div class="row-cols-12 d-flex flex-row d-flex justify-content-center">
            @include('layouts.recruiters.nav')
            <div class="row col-9 d-flex justify-content-around poppins">
                <div class="col-3 bg-black rounded BlocIndexDashBoard">
                </div>
                <div class="col-3 bg-black rounded BlocIndexDashBoard">
                </div>
                <div class="col-3 bg-black rounded BlocIndexDashBoard">
                </div>
            </div>
        </div>
    </div>
@endsection
