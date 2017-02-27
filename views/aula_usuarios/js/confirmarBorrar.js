$('#confirmar-borrar').on('show.bs.modal', function (e) {
    $(this).find('.btn-ok').attr('href', $(e.relatedTarget).data('href'));
    $('#nombre-alumno').text($(e.relatedTarget).data('alumno'));
    $('#confirmar-borrar h4').text($(e.relatedTarget).attr("title"));
});
