
function AddActionForm(){
    var form = document.getElementById('formIndex');
    var btn = document.getElementById('submit');
    btn.setAttribute('type','submit');

    form.setAttribute('action', 'resolution.php'); 
}
