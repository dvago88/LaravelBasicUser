$(document).ready(function () {
    $('body').on("click", ".inactivar", function (e) {
        e.preventDefault();
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
            }
        });
        let $id = $(e.target).siblings()[0].value;
        console.log($id);
        let baseUrl = "http://127.0.0.1:8000/";
        $.ajax({
            url: baseUrl + "api/user/changestatus",
            method: 'post',
            data: {
                id: $id,
            },
            success: function (result) {
                if (result === "inactivo") {
                    $(e.target).text("Activar");
                    $("#" + $id + "status").text("Inactivo");
                } else if (result === "activo") {
                    $(e.target).text("Inactivar");
                    $("#" + $id + "status").text("Activo");
                } else {
                    console.log("Error al activar usuario");
                }
            }
        });
    });
});