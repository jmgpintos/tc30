$(document).ready(function () {
    $('#form1').validate({
        rules: {
            nombre: {
                required: true
            },
            usuario: {
                required: true
            },
            password: {
                required: true

            },
            password_again: {
                required: true,
                equalTo: '#password'
            },
            email: {
                required: true,
                email: true
            },
            telefono: {
                required: true
            }
        }
    });
});
