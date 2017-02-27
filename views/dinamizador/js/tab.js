//Mantener pestaña activa
$(document).ready(function () {
    if (location.hash) {
        $('a[href=' + location.hash + ']').tab('show');
    }
    $(document.body).on("click", "a[data-toggle]", function (event) {
        location.hash = this.getAttribute("href");
    });
});
$(window).on('popstate', function () {
    var anchor = location.hash || $("a[data-toggle=tab]").first().attr("href");
    $('a[href=' + anchor + ']').tab('show');
});


//Autofocus para cada pestaña
$('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
    var target = e.target.attributes.href.value;
    $(target + 'focus').focus();
})