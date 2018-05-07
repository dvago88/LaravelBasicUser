const rows = ["id", "nombre", "cargo", "celular", "correos", "estado"];
$table = $("table");
$table.on('click', ".editButton", (event) => {
    let $tar = $(event.target);
    $tar.parent().siblings().each((index, element) => {

        if (index !== 0) {
            if (index === 3) {
                element.innerHTML = (`<input type="number" name="${rows[index]}" value="${element.textContent}">`);
            } else if (index === 4) {
                let correos = element.textContent;
                let arrCorreos = correos.split(".com");
                element.innerHTML = `<input type="text" name="${rows[index]}1" value="${arrCorreos[0]}.com">
                                     <input type="text" name="${rows[index]}2" value="${arrCorreos[1]}.com">`;
            } else {
                element.innerHTML = (`<input type="text" name="${rows[index]}" value="${element.textContent}">`);
            }
        }
    });
    $tar.parent().html(`<form action="/editar" method="post">
                            <button type="submit">Actualizar</button>
                            <button type="button" class="cancelarButton">Cancelar</button>
                          </form>`);
});


$table.on('click', ".cancelarButton", (event) => {
    let $tar = $(event.target);
    $tar.parent().parent().siblings().each((index, element) => {
        if (index !== 0) {
            if (index === 4) {
                element.innerHTML = `<td>${element.firstChild.value}<br>${element.lastChild.value}</td>`;
            } else if (index === 1) {
                element.innerHTML = `<td><a href="/user/" class="personProfileLink">${element.firstChild.value}</td></a>`;

            } else {
                element.innerHTML = `<td>${element.firstChild.value}</td>`;
            }
        }
    });
    $tar.parent().html(`    <button type="button" class="editButton">Editar</button>
                            <button type="button">Inactivar</button>
                          `);
});


$table.on("click", ".personProfileLink", (event) => {
    let $id = $(event.target).parent().siblings()[0].textContent;
    console.log($id);
    $(event.target).attr("href", event.target.href + $id);
});

