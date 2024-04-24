
function AddActionForm(){
    var form = document.getElementById('formIndex');
    var btn = document.getElementById('submit');
    btn.setAttribute('type','submit');
    
    alert("FORMULARIO ATUALIZADO");
    form.setAttribute('action', 'resolution.php'); 

    btn.click;
}
