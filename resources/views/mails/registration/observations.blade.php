@component('mail::message')
# Novedades en su incripción

Hola {{$name}}, tu incripción al curso **"{{$courseName}}"** tiene observaciones.



Observaciones

- {{$observations}}


Rectifique las observaciones, para que pueda matricularse al curso.<br>
@endcomponent
