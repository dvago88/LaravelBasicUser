@extends("layouts.app")
@section("title","Equipo de Trabajo")
@section("css")
    <link rel="stylesheet" href="{{{asset('css/home.css')}}}">
@stop
@section("content")
    <h1>Equipo de Trabajo</h1>
    <a class="btn btn-primary" href="/user/create">Nuevo Miembro</a>
    <form class="form-inline" action="#">
        <input type="text">
        <button>Buscar</button>
    </form>



    <div>
        <div>
            <h3>Filtar por</h3>
        </div>
        <table>
            <thead>
            <tr>
                <th>Id</th>
                <th>Nombre</th>
                <th>Cargo</th>
                <th>Estado</th>
                <th>Operaciones</th>
            </tr>
            </thead>
            <tbody>
            @foreach($users as $user)
                <tr>
                    <td>{{{$user->id}}}</td>
                    <td>
                        <a href={{ route("user.show",["id"=>$user->id]) }}>{{$user->getName()}}</a>
                    </td>
                    <td>{{{ucfirst($user->position)}}}</td>
                    <td id="{{{$user->id}}}status">{{{ucfirst($user->status)}}}</td>
                    <td>
                        <a href={{route("user.edit",$user)}} class="btn btn-primary">Editar</a>
                        <form action={{route("user.changestatus")}} method="post">
                            <input type="hidden" value="{{{$user->id}}}" name="id">
                            @if($user->status==="activo")
                                <button type="button" class="btn btn-primary inactivar">Inactivar</button>
                            @else
                                <button type="button" class="btn btn-primary inactivar">Activar</button>
                            @endif
                        </form>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
@stop
@section("javascript")
    <script src="{{{asset('js/home.js')}}}"></script>
@stop