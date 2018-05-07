@extends("layout.layout")
@section("title","Formulario")

@section("content")
    <form action="/user" method="post">
        <div class="form-group">
            <label for="nombre">Nombre</label>
            <input type="text" @if(!empty($user)) value="{{{$user->name}}}" @endif class="form-control" id="nombre"
                   name="nombre" placeholder="Ingresa el nombre">
        </div>
        <div class="form-group">
            <label for="primer_apellido">Primer Apellido</label>
            <input type="text" @if(!empty($user)) value="{{{$user->lastname}}}" @endif class="form-control"
                   name="primer_apellido" id="primer_apellido"
                   placeholder="Primer Apellido">
        </div>
        <div class="form-group">
            <label for="segundo_apellido">Segundo Apellido</label>
            <input type="text" @if(!empty($user)) value="{{{$user->second_lastname}}}" @endif class="form-control"
                   id="segundo_apellido" name="segundo_apellido"
                   placeholder="Segundo Apellido">
        </div>
        <div class="form-group">
            <label for="fecha_nacimiento">Fecha de Nacimiento</label>
            <input type="text" @if(!empty($user)) value="{{{$user->birth_date}}}" @endif class="form-control"
                   name="fecha_nacimiento" id="fecha_nacimiento">
        </div>
        <div class="form-group">
            <label for="celular">Celular</label>
            <input type="number" @if(!empty($user)) value="{{{$user->cellphone}}}" @endif class="form-control"
                   name="celular" id="celular" placeholder="Celular">
        </div>
        <div class="form-group">
            <label for="correo_personal">Correo Personal</label>
            <input type="text" @if(!empty($user)) value="{{{$user->personal_email}}}" @endif class="form-control"
                   id="correo_personal" name="correo_personal"
                   placeholder="Correo Personal">
        </div>
        <div class="form-group">
            <label for="correo_empresarial">Correo Empresarial</label>
            <input type="text" @if(!empty($user)) value="{{{$user->business_email}}}" @endif class="form-control"
                   id="correo_empresarial" name="correo_empresarial"
                   placeholder="Correo Empresarial">
        </div>
        <div class="form-group">
            <label for="cargo">Cargo</label>
            <input type="text" @if(!empty($user)) value="{{{$user->position}}}" @endif class="form-control" id="cargo"
                   name="cargo" placeholder="Cargo">
        </div>
        <div class="form-group">
            <label for="contraseña">Contraseña</label>
            <input type="text" class="form-control" id="contraseña" name="contraseña" placeholder="Contraseña">
        </div>
        <div class="form-group">
            <label for="nivel_acceso">Nivel de Accesp</label>
            <input type="text" @if(!empty($user)) value="{{{$user->access_level}}}" @endif class="form-control"
                   id="nivel_acceso" name="nivel_acceso" placeholder="Nivel De Acceso">
        </div>
        <div class="form-check">
            {{--TODO: Simplify that if...--}}
            <input class="form-check-input" type="radio" name="activo" id="activo" value="activo"
                   @if(empty($user)) checked @elseif($user->status=="activo") checked @endif>
            <label class="form-check-label" for="activo"> Activo </label>
        </div>
        <div class="form-check">
            <input class="form-check-input" type="radio" name="inactivo" id="inactivo" value="inactivo"
                   @if(!empty($user) && $user->status=="inactivo") checked @endif>
            <label class="form-check-label" for="inactivo"> Inactivo </label>
        </div>
        <button type="submit" class="btn btn-primary">{{{$accion}}}</button>
    </form>
@stop
