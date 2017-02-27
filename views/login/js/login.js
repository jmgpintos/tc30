

$(document).ready(function () {
    $('#form1').validate({
        rules: {
            usuario: {
                required: true
            },
            password: {
                required: true
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
