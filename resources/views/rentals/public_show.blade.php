@extends('layouts.app')

@section('content')
    @include('rentals.show', ['rental' => $rental])
@endsection
