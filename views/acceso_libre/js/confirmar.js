$('#confirmar-borrar').on('show.bs.modal', function (e) {
    $(this).find('.btn-ok').attr('href', $(e.relatedTarget).data('href'));
    $('#nombre').text($(e.relatedTarget).data('nombre'));
    $('#titulo-modal').text($(e.relatedTarget).attr("title"));
});

$('#confirmar-cerrar-todas').on('show.bs.modal', function (e) {
    $(this).find('.btn-ok').attr('href', $(e.relatedTarget).data('href'));
    $('#centro').text($(e.relatedTarget).data('centro'));
    $('#titulo-modal-cerrar-todas').text($(e.relatedTarget).attr("title"));
});

$('#confirmar-cerrar-antiguas').on('show.bs.modal', function (e) {
    $(this).find('.btn-ok').attr('href', $(e.relatedTarget).data('href'));
    $('#centro-antiguas').text($(e.relatedTarget).data('centro-antiguas'));
    $('#titulo-modal-cerrar-antiguas').text($(e.relatedTarget).attr("title"));
});
