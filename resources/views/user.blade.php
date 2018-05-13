@extends("layouts.app")
@section("title","Person Name")
@section("css")
    <link rel="stylesheet" href="{{{asset('css/user.css')}}}">
@stop
@section("content")
    @if(!empty($user))
        @if(session()->has("passwordFail"))
            <div class="alert alert-danger" role="alert">
                {{{session()->get("passwordFail")}}}
            </div>
        @endif
        @if(session()->has("passwordSuccess"))
            <div class="alert alert-success" role="alert">
                {{{session()->get("passwordSuccess")}}}
            </div>
        @endif
        <h1>{{{$user->getName()}}}</h1>
        <h3>Fecha de Nacimiento</h3>
        <p>{{{$user->birth_date }}}</p>
        <h3>Celular</h3>
        <p>{{{$user->cellphone }}}</p>
        <h3>Correo Personal</h3>
        <p>{{{$user->email }}}</p>
        <h3>Correo Empresarial</h3>
        <p>{{{$user->business_email }}}</p>
        <h3>Cargo</h3>
        <p>{{{$user->position }}}</p>
        <h3>Estado</h3>
        <p id="{{{$user->id}}}status">{{{$user->status }}}</p>
        <a href="{{route("user.edit",$user)}}" class="btn btn-primary">Editar</a>
        <form action="{{route("user.destroy",$user)}}" method="post"
              onsubmit="return confirm('Realmente quieres eliminar este miembro? \nEsta acción no se puede deshacer');">
            {{method_field("DELETE")}}
            {!! csrf_field() !!}
            <button type="submit" class="btn btn-danger">Eliminar
            </button>
        </form>
        <form action={{route("user.changestatus")}} method="post">
            <input type="hidden" value="{{{$user->id}}}" name="id">
            @if($user->status==="activo")
                <button type="button" class="btn btn-primary inactivar">Inactivar</button>
            @else
                <button type="button" class="btn btn-primary inactivar">Activar</button>
            @endif
        </form>
    @else
        <h1>No se encuentra usuario asociado con el codigo {{{$id}}}</h1>
    @endif
    <a href={{route("user.index")}} class="btn btn-primary">Volver al Menú</a>
@stop
@section("javascript")
    <script src="{{{asset('js/home.js')}}}"></script>
@stop