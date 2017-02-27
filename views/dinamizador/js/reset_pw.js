$('#confirmar-restablecer-pw').on('show.bs.modal', function (e) {
    $(this).find('.btn-ok').attr('href', $(e.relatedTarget).data('href'));
    $('#titulo-modal').text($(e.relatedTarget).attr("title"));
});
