$('#editar-matricula').on('show.bs.modal', function (e) {
    console.log('editarMatricula.js');

    var id = $(e.relatedTarget).data('id-ficha-alumno');
    $(this).find('.btn-ok').attr('href', $(e.relatedTarget).data('href') + id);


//    console.log('boton:' + $('#btn-ok-editar'));
//    console.log('id:'+ id);
//    console.log('href:' + $(e.relatedTarget).data('href'));
////    id = 'aa';
//    console.log('href+id:' + $(e.relatedTarget).data('href') + id);
//    var alumno = $(e.relatedTarget).data('alumno');

    $('#curso').text($(e.relatedTarget).data('curso'));
    $('#nombre-alumno-matricula').text($(e.relatedTarget).data('alumno'));

    //    console.log($(e.relatedTarget).data('alumno'));

    $('#titulo-modal').text($(e.relatedTarget).attr("title"));
});
