
$(document).ready(function () {

    var getUsuarios = function () {
        $.post('getusuarios_ajax', 'id_centro=' + $("#id_centro").val(), function (datos) {
            $("#id_profesor").html('');
            var id_centro = $('#id_centro').val();
            for (var i = 0; i < datos.length; i++) {
                if (datos[i].id_centro == id_centro) {
                    opt = 'selected';
                } else {
                    opt = ''
                }
                $('#id_profesor').append('<option ' + opt + ' value="' + datos[i].id + '">' + datos[i].nombre + '</option>');
            }
        }, 'json');
    }

    $('#id_centro').change(function () {
        if (!$('#id_centro').val()) {
            $("#idusuario").html('')
        } else {
            getUsuarios();
        }
    });

});