$('#confirmar-borrar').on('show.bs.modal', function (e) {
    $(this).find('.btn-ok').attr('href', $(e.relatedTarget).data('href'));
//    $('h4').text($(e.relatedTarget).data('title'));
    $('#nombre').text($(e.relatedTarget).data('nombre'));
    $('#tabla').text($(e.relatedTarget).data('tabla'));
    $('#titulo-modal').text($(e.relatedTarget).attr("title"));
});
