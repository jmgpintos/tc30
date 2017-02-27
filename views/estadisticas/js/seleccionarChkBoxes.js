$(function() {
    
    $('#btnseleccionarTodos').show();
    $('#btnseleccionarNinguno').hide();
})


function seleccionarTodos(){
    var chkBoxes = $('#SQLs input[type=checkbox]');
    
    console.log(chkBoxes);
    for (i=0;i<chkBoxes.length;i++){
        chkBoxes[i].checked=true;
    }
    $('#btnseleccionarTodos').hide();
    $('#btnseleccionarNinguno').show();
}

function seleccionarNinguno(){
    var chkBoxes = $('#SQLs input[type=checkbox]');
    
    console.log(chkBoxes);
    for (i=0;i<chkBoxes.length;i++){
        chkBoxes[i].checked=false;
    }
    
    $('#btnseleccionarTodos').show();
    $('#btnseleccionarNinguno').hide();
}