
$(document).ready(function () {

    var getUsuarios = function (centro) {
        $.post('ficha_cursos/getusuarios_ajax', 'id_centro=' + $("#id_centro").val(), function (datos) {
            $("#usuario").html('')
            for (var i = 0; i < datos.length; i++) {
                if (datos[i].centro == centro) {
                    opt = 'selected';
                } else {
                    opt = ''
                }
                $('#id_usuario').append('<option ' + opt + ' value="' + datos[i].id + '">' + datos[i].nombre + '</option>');
            }
        }, 'json');
    }

    $('#id_centro').change(function () {
        alert('cambia centro');
        if (!$('#id_centro').val()) {
            $("#id_profesor").html('')
        } else {
            getUsuarios();
        }
    });

});