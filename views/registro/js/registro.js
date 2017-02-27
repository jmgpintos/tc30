


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
                required: true,
                minlength: 4
            },
            password1: {
                equalTo: '#password'
            },
            email: {
                required: true,
                email: true
            }
        },
//        messages: {
//            usuario:{
//                required: "Debe introducir el nombre de usuario"
//            },
//            password:{
//                required: "Debe introducir la contraseña"
//            }
//        }
    });
});

