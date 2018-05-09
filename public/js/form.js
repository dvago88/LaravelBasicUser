$("form").on("click", "#change_password", () => {
    $("#user_inputs").append(`
    <div class="form-group" id="pass_change">
        <label for="contraseña">Escribe la contraseña Anterior</label>
        <input type="password"class="form-control" id="contraseñaAntigua" name="contraseñaAntigua" placeholder="Contraseña Antigua">
        <label for="contraseña">Escribe la contraseña Nueva</label>
        <input type="password"class="form-control" id="contraseña" name="contraseña" placeholder="Contraseña Nueva">
        <label for="contraseña">Escribe la contraseña Nueva otra vez</label>
        <input type="password"class="form-control" id="contraseñaRevisador" name="contraseñaRevisador" placeholder="Contraseña Nueva">
        <button type="button" class="btn btn-primary" id="cancel_pass_change">Cancelar</button>
    </div>
    `);
    $("#change_password").remove();
});

$("form").on("click", "#cancel_pass_change", () => {
    $("#pass_change").remove();
    $("form").append(`<button type="button" class="btn btn-primary" id="change_password">Cambiar contraseña</button>`);
});