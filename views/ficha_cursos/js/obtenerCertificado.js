$('#modal-certificado').on('show.bs.modal', function (e) {

    var now = new Date();
    var day = ("0" + now.getDate()).slice(-2);
    var month = ("0" + (now.getMonth() + 1)).slice(-2);
    var hoy = now.getFullYear() + "-" + (month) + "-" + (day);

    var margen = 25;

    $('#fecha-certificado').val(hoy);
    $('#margen').val(margen);

    $('#form-fecha').attr('action', $(e.relatedTarget).data('href'));
    $('#form-fecha').attr('target', '_blank');
    $(this).find('.btn-ok').attr('href', $(e.relatedTarget).data('href'));
    $('#cert-curso').text($(e.relatedTarget).data('curso'));
    $('#cert-nombre-alumno').text($(e.relatedTarget).data('alumno'));
    $('#titulo-modal').text($(e.relatedTarget).attr("title"));
});

$("input#submit").click(function () {
    $.ajax({
        type: "POST",
        data: $('form.fecha').serialize()
    });
    $('#modal-certificado').modal('hide');
});
