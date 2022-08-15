@extends('mails.index')
@section('content')
    <div class="row">
        <div class="col-12 text-muted ">
            <h3 class="text-center">Novedades en su incripción</h3>
            <br>
            <p>Su incripción al curso {{true}} tienes observaciones.
            </p>
            <br>
            <b>Observaciones</b>
            <p>{{false}}</p>
            <br>
            <br>
            <p>Rectifique las observaciones, para que pueda matricularse al curso.</p>
        </div>
        <!-- incluir dentro de observation.blade.php -->
        @component('mail::button', ['url' => 'http//::www.google.com'])
Revisar en la plataforma
@endcomponent
    </div>
@endsection
