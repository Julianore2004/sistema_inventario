$(document).ready(function() {
    load(1);
});

function load(page) {
    let categoria = $("#id_categoria").val();
    $("#loader").fadeIn('slow');
    $.ajax({
        url: './ajax/buscar_reportes.php?action=ajax&page=' + page + '&q=' + categoria,
        beforeSend: function() {
            $('#loader').html('<img src="./img/ajax-loader.gif"> Cargando...');
        },
        success: function(data) {
            $(".outer_div").html(data).fadeIn('slow');
            $('#loader').html('');
        }
    });
}

function exportar_excel() {
    let categoria = $("#id_categoria").val();
    if (categoria) {
        // Si hay una categoría seleccionada, agrega el parámetro a la URL
        window.location = "reporte_stock.php?id_categoria=" + categoria;
    } else {
        // Si no hay categoría seleccionada, genera el reporte general
        window.location = "reporte_stock.php";
    }
}
