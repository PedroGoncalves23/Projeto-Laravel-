@extends('layouts.panel')
@section('title', 'Editar evento')
@section('content')
    <form action="{{ route('organization.events.update', $event->id)}}" method="POST" autocomplete="off">
        @method('PUT')
        @include('organization.events._partials.form') <!-- IMPORTA O FORM DE CADASTRO -->
    </form>
@endsection