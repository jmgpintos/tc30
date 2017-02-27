var el = $('li>a>strong#login').closest('li');

el.addClass('bg-primary');
el.hover(function () {
    el.addClass('bg-success');
    el.removeClass('bg-primary');
}, function () {
    el.removeClass('bg-success');
    el.addClass('bg-primary');
});
