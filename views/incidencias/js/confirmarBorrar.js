$('#confirmar-borrar').on('show.bs.modal', function (e) {
    var desc = $(e.relatedTarget).data('centro');
    desc = desc + ' / ' + $(e.relatedTarget).data('equipo');
    desc = desc + ' / ' + $(e.relatedTarget).data('tipo');
    var fecha = $(e.relatedTarget).data('fecha');
    console.log(desc);
    console.log(fecha);
    console.log('1');
$(this).find('.btn-ok').attr('href', $(e.relatedTarget).data('href'));
        $('#centro-incidencia').text($(e.relatedTarget).data('centro'));
        $('#equipo-incidencia').text($(e.relatedTarget).data('equipo'));
        $('#tipo-incidencia').text($(e.relatedTarget).data('tipo'));
        $('#fecha-incidencia').text(fecha);
        $('#titulo-modal').text($(e.relatedTarget).attr("title"));
        });
        
        
//        
//        data - centro = "{$item.id_centro}"
//        data - equipo = "{$item.id_equipo}"
//        data - tipo = "{$item.tipo}"
//        data - fecha = "{$item.fecha_creacion}"