@extends("layouts.app")
@section("title","Formulario")
@section("css")
    <link rel="stylesheet" href="{{{asset('css/form.css')}}}">
@stop
@section("content")
    @if($errors->any() || session()->has("errors"))
        <div class="alert alert-danger" role="alert">
            Hay campos con errores
        </div> @endif
    @if($errors->has("passwordChecker"))
        <div class="alert alert-danger" role="alert">
            La password es muy corta
        </div> @endif
    @if(!empty($user))
        <form action={{route("user.update",["id"=>$user->id])}} method="post">

            {{method_field("PUT")}}
            @else
                <form action={{route("user.store")}} method="post">
                    @endif
                    {!! csrf_field() !!}
                    <input type="hidden" @if(!empty($user)) value="{{{$user->id}}}" @else value="0"
                           @endif name="id">
                    <div id="user_inputs">
                        <div class="form-group">
                            <label for="name">name</label>
                            <input type="text" @if(!empty($user)) value="{{{old("name",$user->name)}}}"
                                   @else value="{{{old('name')}}}"
                                   @endif class="form-control" id="name"
                                   name="name" placeholder="Ingresa el nombrel">
                            @if($errors->has("name"))
                                <p class="validation_error">{{{$errors->first("name")}}}</p>
                            @endif
                        </div>
                        <div class="form-group">
                            <label for="lastname">Primer Apellido</label>
                            <input type="text" class="form-control" name="lastname" id="lastname"
                                   placeholder="Primer Apellido"
                                   @if(!empty($user)) value="{{{old("lastname",$user->second_lastname)}}}"
                                   @else value="{{{old('lastname')}}}" @endif>
                            @if($errors->has("lastname"))
                                <p class="validation_error">{{{$errors->first("lastname")}}}</p>
                            @endif
                        </div>
                        <div class="form-group">
                            <label for="second_lastname">Segundo Apellido</label>
                            <input type="text" class="form-control" id="second_lastname" name="second_lastname"
                                   placeholder="Segundo Apellido"
                                   @if(!empty($user)) value="{{{$user->second_lastname}}}"
                                   @else value="{{{old('second_lastname')}}}" @endif>
                            @if($errors->has("second_lastname"))
                                <p class="validation_error">{{{$errors->first("second_lastname")}}}</p>
                            @endif
                        </div>
                        <div class="form-group">
                            <label for="birth_date">Fecha de Nacimiento</label>
                            <input type="date" class="form-control" name="birth_date" id="birth_date"
                                   @if(!empty($user)) value="{{{$user->birth_date}}}"
                                   @else value="{{{old('birth_date')}}}" @endif>
                            @if($errors->has("birth_date"))
                                <p class="validation_error">{{{$errors->first("birth_date")}}}</p>
                            @endif
                        </div>
                        <div class="form-group">
                            <label for="cellphone">Celular</label>
                            <input type="number" class="form-control" name="cellphone" id="cellphone"
                                   placeholder="Celular"
                                   @if(!empty($user)) value="{{{$user->cellphone}}}"
                                   @else value="{{{old('cellphone')}}}" @endif>
                            @if($errors->has("cellphone"))
                                <p class="validation_error">{{{$errors->first("cellphone")}}}</p>
                            @endif
                        </div>
                        <div class="form-group">
                            <label for="email">Correo Personal</label>
                            <input type="email" class="form-control" id="email" name="email"
                                   placeholder="Correo Personal"
                                   @if(!empty($user)) value="{{{$user->email}}}"
                                   @else value="{{{old('email')}}}" @endif>
                            @if($errors->has("email"))
                                <p class="validation_error">{{{$errors->first("email")}}}</p>
                            @endif
                        </div>
                        <div class="form-group">
                            <label for="business_email">Correo Empresarial</label>
                            <input type="text" class="form-control" id="business_email"
                                   name="business_email"
                                   placeholder="Correo Empresarial"
                                   @if(!empty($user)) value="{{{$user->business_email}}}"
                                   @else value="{{{old('business_email')}}}" @endif>
                            @if($errors->has("business_email"))
                                <p class="validation_error">{{{$errors->first("business_email")}}}</p>
                            @endif
                        </div>
                        @if(empty($user))
                            <div class="form-group">
                                <label for="password">Contraseña</label>
                                <input type="password" class="form-control" id="password" name="password"
                                       placeholder="Escribe la contraseña">
                                <input type="password" class="form-control" id="passwordChecker"
                                       name="passwordChecker"
                                       placeholder="Escribe la password de nuevo">
                                @if($errors->has("password"))
                                    <p class="validation_error">{{{$errors->first("password")}}}</p>
                                @endif
                                @if(session()->has("passwordDifferent"))
                                    <p class="validation_error">{{{session()->get("passwordDifferent")}}}</p>
                                @endif
                            </div>
                        @endif
                        <div class="form-group">
                            <label for="position">Cargo</label>
                            <input type="text" class="form-control" id="position" name="position" placeholder="Cargo"
                                   @if(!empty($user)) value="{{{$user->position}}}"
                                   @else value="{{{old('position')}}}" @endif>
                            @if($errors->has("position"))
                                <p class="validation_error">{{{$errors->first("position")}}}</p>
                            @endif
                        </div>
                        <div class="form-group">
                            <label for="access_level">Nivel de Acceso</label>
                            <input type="text" class="form-control" id="access_level" name="access_level"
                                   placeholder="Nivel De Acceso"
                                   @if(!empty($user)) value="{{{$user->access_level}}}"
                                   @else value="{{{old('access_level')}}}" @endif>
                            @if($errors->has("access_level"))
                                <p class="validation_error">{{{$errors->first("access_level")}}}</p>
                            @endif
                        </div>
                        <div class="form-check">
                            {{--TODO: Simplify that if...--}}
                            <input class="form-check-input" type="radio" name="activo" id="activo" value="activo"
                                   @if(empty($user)) checked @elseif($user->status=="activo") checked @endif>
                            <label class="form-check-label" for="activo"> Activo </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="inactivo" id="inactivo"
                                   value="inactivo"
                                   @if(!empty($user) && $user->status=="inactivo") checked @endif>
                            <label class="form-check-label" for="inactivo"> Inactivo </label>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary">{{{$accion}}}</button>
                    <a href={{route("user.index")}} class="btn btn-primary">Volver al Menú</a>
                    @if(!empty($user))
                        <button type="button" class="btn btn-primary" id="change_password">Cambiar Contraseña
                        </button>
                    @endif
                </form>
                @stop
            @section("javascript")
                <script src="{{{asset('js/form.js')}}}"></script>
@stop
