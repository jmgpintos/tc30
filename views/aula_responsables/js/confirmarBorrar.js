$('#confirmar-borrar').on('show.bs.modal', function (e) {
    $(this).find('.btn-ok').attr('href', $(e.relatedTarget).data('href'));
    $('#curso').text($(e.relatedTarget).data('curso'));
    $('#nombre-alumno').text($(e.relatedTarget).data('alumno'));
    $('.modal-title').text($(e.relatedTarget).attr("title"));
});
