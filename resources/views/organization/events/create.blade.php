@extends('layouts.panel')
@section('title', 'Novo evento')
@section('content')
    <form action="{{ route('organization.events.store')}}" method="POST" autocomplete="off">
       @include('organization.events._partials.form') <!-- IMPORTA O FORM DE CADASTRO -->
    </form>
@endsection