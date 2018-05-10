@extends("layout.layout")
@section("title","Formulario")
@section("css")
    <link rel="stylesheet" href="{{{asset('css/form.css')}}}">
@stop
@section("content")
    @if($errors->any())
        <div class="alert alert-danger" role="alert">
            Hay campos con errores
        </div> @endif
    @if(!empty($user))
        <form action={{route("user.update",["id"=>$user->id])}} method="post">

            {{method_field("PUT")}}
            @else
                <form action={{route("user.store")}} method="post">
                    @endif
                    {!! csrf_field() !!}
                    <input type="hidden" @if(!empty($user)) value="{{{$user->id}}}" @else value="0" @endif name="id">
                    <div id="user_inputs">
                        <div class="form-group">
                            <label for="nombre">Nombre</label>
                            <input type="text" @if(!empty($user)) value="{{{old("nombre",$user->name)}}}"
                                   @else value="{{{old('nombre')}}}"
                                   @endif class="form-control" id="nombre"
                                   name="nombre" placeholder="Ingresa el nombre">
                            @if($errors->has("nombre"))
                                <p class="validation_error">{{{$errors->first("nombre")}}}</p>
                            @endif
                        </div>
                        <div class="form-group">
                            <label for="primer_apellido">Primer Apellido</label>
                            <input type="text" class="form-control" name="primer_apellido" id="primer_apellido"
                                   placeholder="Primer Apellido"
                                   @if(!empty($user)) value="{{{old("primer_apellido",$user->lastname)}}}"
                                   @else value="{{{old('primer_apellido')}}}" @endif>
                            @if($errors->has("primer_apellido"))
                                <p class="validation_error">{{{$errors->first("primer_apellido")}}}</p>
                            @endif
                        </div>
                        <div class="form-group">
                            <label for="segundo_apellido">Segundo Apellido</label>
                            <input type="text" class="form-control" id="segundo_apellido" name="segundo_apellido"
                                   placeholder="Segundo Apellido"
                                   @if(!empty($user)) value="{{{$user->second_lastname}}}"
                                   @else value="{{{old('segundo_apellido')}}}" @endif>
                            @if($errors->has("segundo_apellido"))
                                <p class="validation_error">{{{$errors->first("segundo_apellido")}}}</p>
                            @endif
                        </div>
                        <div class="form-group">
                            <label for="fecha_nacimiento">Fecha de Nacimiento</label>
                            <input type="date" class="form-control" name="fecha_nacimiento" id="fecha_nacimiento"
                                   @if(!empty($user)) value="{{{$user->birth_date}}}"
                                   @else value="{{{old('fecha_nacimiento')}}}" @endif>
                            @if($errors->has("fecha_nacimiento"))
                                <p class="validation_error">{{{$errors->first("fecha_nacimiento")}}}</p>
                            @endif
                        </div>
                        <div class="form-group">
                            <label for="celular">Celular</label>
                            <input type="number" class="form-control" name="celular" id="celular" placeholder="Celular"
                                   @if(!empty($user)) value="{{{$user->cellphone}}}"
                                   @else value="{{{old('celular')}}}" @endif>
                            @if($errors->has("celular"))
                                <p class="validation_error">{{{$errors->first("celular")}}}</p>
                            @endif
                        </div>
                        <div class="form-group">
                            <label for="correo_personal">Correo Personal</label>
                            <input type="email" class="form-control" id="correo_personal" name="correo_personal"
                                   placeholder="Correo Personal"
                                   @if(!empty($user)) value="{{{$user->personal_email}}}"
                                   @else value="{{{old('correo_personal')}}}" @endif>
                            @if($errors->has("correo_personal"))
                                <p class="validation_error">{{{$errors->first("correo_personal")}}}</p>
                            @endif
                        </div>
                        <div class="form-group">
                            <label for="correo_empresarial">Correo Empresarial</label>
                            <input type="text" class="form-control" id="correo_empresarial" name="correo_empresarial"
                                   placeholder="Correo Empresarial"
                                   @if(!empty($user)) value="{{{$user->business_email}}}"
                                   @else value="{{{old('correo_empresarial')}}}" @endif>
                            @if($errors->has("correo_empresarial"))
                                <p class="validation_error">{{{$errors->first("correo_empresarial")}}}</p>
                            @endif
                        </div>
                        @if(empty($user))
                            <div class="form-group">
                                <label for="contraseña">Contraseña</label>
                                <input type="password" class="form-control" id="contraseña" name="contraseña"
                                       placeholder="Escribe la Contraseña">
                                @if($errors->has("contraseña"))
                                    <p class="validation_error">{{{$errors->first("contraseña")}}}</p>
                                @endif
                            </div>
                        @endif
                        <div class="form-group">
                            <label for="cargo">Cargo</label>
                            <input type="text" class="form-control" id="cargo" name="cargo" placeholder="Cargo"
                                   @if(!empty($user)) value="{{{$user->position}}}"
                                   @else value="{{{old('cargo')}}}" @endif>
                            @if($errors->has("contraseña"))
                                <p class="validation_error">{{{$errors->first("contraseña")}}}</p>
                            @endif
                        </div>
                        <div class="form-group">
                            <label for="nivel_acceso">Nivel de Acceso</label>
                            <input type="text" class="form-control" id="nivel_acceso" name="nivel_acceso"
                                   placeholder="Nivel De Acceso"
                                   @if(!empty($user)) value="{{{$user->access_level}}}"
                                   @else value="{{{old('nivel_acceso')}}}" @endif>
                            @if($errors->has("nivel_acceso"))
                                <p class="validation_error">{{{$errors->first("nivel_acceso")}}}</p>
                            @endif
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
                    </div>
                    <button type="submit" class="btn btn-primary">{{{$accion}}}</button>
                    <a href={{route("user.index")}} class="btn btn-primary">Volver al Menú</a>
                    @if(!empty($user))
                        <button type="button" class="btn btn-primary" id="change_password">Cambiar contraseña</button>
                    @endif
                </form>
                @stop
            @section("javascript")
                <script src="{{{asset('js/form.js')}}}"></script>
@stop
