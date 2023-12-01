<x-mail::message>
    HOLA {{ $user->name  }},

    TU TAREA {{ $tarea->titulo }} HA SIDO FINALIZADA EXITOSAMENTE
    
    Gracias,
    EQUIPO {{ config('app.name') }}
</x-mail::message>
