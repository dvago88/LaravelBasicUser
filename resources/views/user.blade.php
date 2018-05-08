@extends("layout.layout")
@section("title","Person Name")
@section("css")
    <link rel="stylesheet" href="{{{asset('css/user.css')}}}">
@stop
@section("content")
    @if(!empty($user))
    <h1>{{{$user->name}}} {{{ $user->lastname }}} {{{ $user->second_lastname }}}</h1>
    <h3>Fecha de Nacimiento</h3>
    <p>{{{$user->birth_date }}}</p>
    <h3>Celular</h3>
    <p>{{{$user->cellphone }}}</p>
    <h3>Correo Personal</h3>
    <p>{{{$user->personal_email }}}</p>
    <h3>Correo Empresarial</h3>
    <p>{{{$user->business_email }}}</p>
    <h3>Cargo</h3>
    <p>{{{$user->position }}}</p>
    <h3>Estado</h3>
    <p>{{{$user->status }}}</p>
    <a href="/user/{{{$user->id}}}/edit" class="btn btn-primary">Editar</a>
    <button class="btn btn-primary">Inactivar</button>
        @else
        <h1>No se encuentra usuario asociado con el codigo {{{$id}}}</h1>
    @endif
@stop
@section("javascript")
    <script src="{{{asset('js/user.js')}}}"></script>
@stop