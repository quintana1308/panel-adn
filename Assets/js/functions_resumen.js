function redirigirEmpresa() {

    var valorSeleccionado = document.getElementById('miSelect').value;
    var xhr = new XMLHttpRequest();
    xhr.open("POST", base_url+'/Usuarios/putDUser');
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    xhr.onload = function() {
      if (xhr.status === 200) {
        var respuesta = JSON.parse(xhr.responseText);
        if (respuesta.status === true) {
          location.reload();
        }
      }
    };
    xhr.send("intDashboard=" + valorSeleccionado);


    //const empresa = document.getElementById('miSelect').value;
    
    // Si el valor no está vacío, redirige
    /*if (empresa) {
        const baseUrl = document.getElementById('url').dataset.value; // Obtenemos la URL base
        window.location.href = `${baseUrl}/resumen?empresa=${empresa}`;
    }*/
}