$('#confirmar-imprimir-hojas-cursos').on('show.bs.modal', function (e) {
//    $(this).find('.btn-ok').attr('href', $(e.relatedTarget).data('href'));
//    $(this).find('.btn-ok').attr('target', '_blank');
    $('#form-imprimir').attr('action', $(e.relatedTarget).data('href'));
    $('#form-imprimir').attr('target', '_blank');
    $('#total').text($(e.relatedTarget).data('total'));
    $('#titulo-modal').text($(e.relatedTarget).attr("title"));
});


$("input#submit").click(function () {
    $.ajax({
        type: "POST",
        data: $('form.imprimir').serialize()
    });
    $('#confirmar-imprimir-hojas-cursos').modal('hide');
});



//$("input#submit").click(function () {
//    $.ajax({
//        type: "POST",
//        data: $('form.fecha').serialize()
//    });
//    $('#modal-certificado').modal('hide');
//});
