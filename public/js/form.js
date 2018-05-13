$("body").on("click", "#change_password", () => {
    console.log("puta vida");
    $("#user_inputs").append(`
    <div class="form-group" id="pass_change">
        <label for="password">Escribe la contraseña Anterior</label>
        <input type="password"class="form-control" id="oldPassword" name="oldPassword" placeholder="password Antigua">
        <label for="password">Escribe la contraseña Nueva</label>
        <input type="password"class="form-control" id="password" name="password" placeholder="Contraseña Nueva">
        <label for="password">Escribe la contraseña Nueva otra vez</label>
        <input type="password"class="form-control" id="passwordChecker" name="passwordChecker" placeholder="Contraseña Nueva">
        <button type="button" class="btn btn-primary" id="cancel_pass_change">Cancelar</button>
    </div>
    `);
    $("#change_password").remove();
    console.log("putisima");
});

$("body").on("click", "#cancel_pass_change", () => {
    $("#pass_change").remove();
    $("form").append(`<button type="button" class="btn btn-primary" id="change_password">Cambiar contraseña</button>`);
});