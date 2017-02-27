function cambia_fecha() {
    if ($('#fecha_fin').val() == '') {
        var fechaInicio = new Date($('#fecha_inicio').val());
        var fechaFin = new Date(fechaInicio);
        fechaFin.setDate(fechaInicio.getDate() + 4);
        console.log(fechaInicio);
        console.log(fechaFin);

        var dd = fechaFin.getDate();
        var mm = fechaFin.getMonth() + 1;
        var y = fechaFin.getFullYear();
        dd = dd.toString();
        if (dd.length < 2) {
            dd = '0' + dd.toString();
        }
        mm = mm.toString();
        if (mm.length < 2) {
            mm = '0' + mm.toString();
        }

        var fechaFormateada = y + '-' + mm + '-' + dd;
        console.log(fechaFormateada);
        $('#fecha_fin').val(fechaFormateada);
    }
}

function cambia_hora() {
    if ($('#hora_fin').val() == '') {
        var hora = $('#hora_inicio').val();
        var horaInicio = hora.substring(0, 2);
        var minutoInicio = hora.substring(3, 5);
        console.log($('#hora_inicio').val());
        console.log('horaInicio: ' + horaInicio);
        console.log('minutoInicio: ' + minutoInicio);
        var horaFin = parseInt(horaInicio) + 2;
        horaFin = horaFin.toString() + ':' + minutoInicio.toString();
        console.log(horaFin);
        $('#hora_fin').val(horaFin);
    }
}