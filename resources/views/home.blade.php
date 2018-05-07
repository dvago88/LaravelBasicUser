@extends("layout.layout")
@section("title","User")
@section("css")
    <link rel="stylesheet" href="{{{asset('css/home.css')}}}">
@stop
@section("content")
    <h1>Equipo de Trabajo</h1>
    <div>
        <table>
            <thead>
            <tr>
                <th>Id</th>
                <th>Nombre</th>
                <th>Cargo</th>
                <th>Celular</th>
                <th>Correos</th>
                <th>Estado</th>
                <th>Operaciones</th>
            </tr>
            </thead>
            <tbody>
            @foreach($users as $user)
                <tr>
                    <td>{{{$user->id}}}</td>
                    <td><a href="/user/" class="personProfileLink">{{{$user->name}}} {{{$user->lastname}}} {{{$user->second_lastname}}}</a>
                    </td>
                    <td>{{{$user->position}}}</td>
                    <td>{{{$user->cellphone}}}</td>
                    <td>{{{$user->personal_email}}}<br>{{{$user->business_email}}}</td>
                    <td>{{{$user->status}}}</td>
                    <td>
                        <button type="button" class="editButton">Editar</button>
                        <button>Inactivar</button>
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