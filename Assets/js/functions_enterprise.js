let tableEnterprises;
let divLoading = document.querySelector("#divLoading");

const base_url = document.getElementById('url').dataset.value;

document.addEventListener('DOMContentLoaded', function(){

    if(document.querySelector("#formEnterprise")){
        let formEnterprise = document.querySelector("#formEnterprise");
        formEnterprise.onsubmit = function(e) {
            e.preventDefault();
            
            let token = document.querySelector('#token').value;
            let bd = document.querySelector('#bd').value;
            let rif = document.querySelector('#rif').value;
            let nombre = document.querySelector('#nombre').value;
            let tokenpanel = document.querySelector('#tokenpanel').value;
            let urlpanel = document.querySelector('#urlpanel').value;
            let bdSincro = document.querySelector('#bdSincro').value;

            if(token == '' || bd == '' || rif == '' || nombre == '' || tokenpanel == '' || urlpanel == '' || bdSincro == '')
            {
                Swal.fire("Atención", "Todos los campos son obligatorios" , "error");
                return false;
            }

            divLoading.style.display = "flex";
            let request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
            let ajaxUrl = base_url+'/Enterprise/setEnterprise'; 
            let formData = new FormData(formEnterprise);
            request.open("POST",ajaxUrl,true);
            request.send(formData);


            request.onreadystatechange = function(){
                if(request.readyState == 4 && request.status == 200){
                    let objData = JSON.parse(request.responseText);

                    if(objData.status)
                    {   
                        divLoading.style.display = "none";
                        $('#modalFormEnterprise').modal("hide");
                        formEnterprise.reset();
                        Swal.fire("Empresa", objData.msg ,"success");
                        tableEnterprises.api().ajax.reload();
                    }else{
                        Swal.fire("Error", objData.msg , "error");
                    }
                }
                return false;
            }
        }
    }

    if(document.querySelector("#formEnterpriseEdit")){
        let formEnterpriseEdit = document.querySelector("#formEnterpriseEdit");
        formEnterpriseEdit.onsubmit = function(e) {
            e.preventDefault();

            let idEnterprise = document.querySelector('#idEnterpriseEdit').value;
            let token = document.querySelector('#tokenEdit').value;
            let bd = document.querySelector('#bdEdit').value;
            let rif = document.querySelector('#rifEdit').value;
            let nombre = document.querySelector('#nombreEdit').value;
            let tokenpanel = document.querySelector('#tokenpanelEdit').value;
            let urlpanel = document.querySelector('#urlpanelEdit').value;

            if(token == '' || bd == '' || rif == '' || nombre == '')
            {
                Swal.fire("Atención", "Todos los campos son obligatorios" , "error");
                return false;
            }

            divLoading.style.display = "flex";
            let request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
            let ajaxUrl = base_url+'/Enterprise/putEnterpriseData'; 
            let formData = new FormData(formEnterpriseEdit);
            request.open("POST",ajaxUrl,true);
            request.send(formData);


            request.onreadystatechange = function(){
                if(request.readyState == 4 && request.status == 200){
                    let objData = JSON.parse(request.responseText);

                    if(objData.status)
                    {
                        divLoading.style.display = "none";
                        $('#modalFormEnterpriseEdit').modal("hide");
                        formEnterpriseEdit.reset();
                        Swal.fire("Empresa", objData.msg ,"success");
                        tableEnterprises.api().ajax.reload();
                    }else{
                        Swal.fire("Error", objData.msg , "error");
                    }
                }
                return false;
            }
        }
    }

    tableEnterprises = $('#tableEnterprises').dataTable( { 
        "aProcessing":true,
        "aServerSide":true,
        "language": {           
            "processing": "Procesando...",
            "lengthMenu": "Mostrar _MENU_ registros",
            "zeroRecords": "No se encontraron resultados",
            "emptyTable": "Ningún dato disponible en esta tabla",
            "infoEmpty": "Mostrando registros del 0 al 0 de un total de 0 registros",
            "infoFiltered": "(filtrado de un total de _MAX_ registros)",
            "search": "Buscar:",
            "infoThousands": ",",
            "loadingRecords": "Cargando...",
            "paginate": {
                "first": "Primero",
                "last": "Último",
                "next": ">",
                "previous": "<"
            },
            "info": "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros"
        },
        "ajax":{
            "url": " "+base_url+"/Enterprise/getEnterprises",
            "dataSrc":""
        },
        "columns":[
            {"data":"ID"},
            {"data":"TOKEN"},
            {"data":"BD"},
            {"data":"RIF"},
            {"data":"NOMBRE"},
            {
                "data": "URLPANEL",
                "render": function(data, type, row) {
                    // Agrega un botón de copiar usando la clase `btnCopyUserToken`
                    const maxLength = 14;
                    if(data){
                        return `<span class="truncate">${data.length > maxLength ? data.substr(0, maxLength) + "..." : data}</span>
                            <button class="btnCopyUserToken btn btn-light p-1 mb-0" 
                            data-clipboard-text="${data}" title="Copiar">
                            <i class="far fa-copy"></i></button>`;
                    }else{
                        return `No hay Url`;    
                    }
                    
                }
            },
            {
                "data": "TOKENPANEL",
                "render": function(data, type, row) {
                    // Agrega un botón de copiar usando la clase `btnCopyUserToken`
                    const maxLength = 14;
                    if(data){
                        return `<span class="truncate">${data.length > maxLength ? data.substr(0, maxLength) + "..." : data}</span>
                            <button class="btnCopyUserToken btn btn-light p-1 mb-0" 
                            data-clipboard-text="${data}" title="Copiar">
                            <i class="far fa-copy"></i></button>`;    
                    }else{
                        return `No hay Token`;
                    }
                    
                }
            },
            {"data": "options"}
        ],
        "columnDefs": [
            { "className": "textcenter", "targets": [ 0 ] },
            { "className": "textcenter", "targets": [ 2 ] },
            { "className": "textcenter", "targets": [ 3 ] }
        ],
        'dom': 'lBfrtip',
        'buttons': [
            {
                "extend": "copyHtml5",
                "text": "<i class='far fa-copy'></i> Copiar",
                "titleAttr":"Copiar",
                "className": "btn btn-secondary"
            },{
                "extend": "pdfHtml5",
                "text": "<i class='fas fa-file-pdf'></i> PDF",
                "titleAttr":"Esportar a PDF",
                "className": "btn btn-danger"
            }
        ],
        "resonsieve":"true",
        "bDestroy": true,
        "iDisplayLength": 100,
        "order":[[0,"asc"]]  
    });

    new ClipboardJS('.btnCopyUserToken');

}, false);

function fntEditEnterprise(element,idEnterprise){
    rowTable = element.parentNode.parentNode.parentNode; 
    //document.querySelector('#titleModal').innerHTML ="Actualizar Usuario";
    //document.querySelector('.modal-header').classList.replace("headerRegister", "headerUpdate");
    //document.querySelector('#btnActionForm').classList.replace("btn-primary", "btn-info");
    //document.querySelector('#btnText').innerHTML ="Actualizar";

    let request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
    let ajaxUrl = base_url+'/Enterprise/getEnterprise/'+idEnterprise;
    request.open("GET",ajaxUrl,true);
    request.send();
    request.onreadystatechange = function(){

        if(request.readyState == 4 && request.status == 200){
            let objData = JSON.parse(request.responseText);
            
            if(objData.status)
            {   
                document.querySelector("#idEnterpriseEdit").value = objData.data.ID;
                document.querySelector("#tokenEdit").value = objData.data.TOKEN;
                document.querySelector("#bdEdit").value = objData.data.BD;
                document.querySelector("#rifEdit").value = objData.data.RIF;
                document.querySelector("#nombreEdit").value =objData.data.NOMBRE;
                document.querySelector("#tokenpanelEdit").value =objData.data.TOKENPANEL;
                document.querySelector("#urlpanelEdit").value =objData.data.URLPANEL;
            }
        }
    
        $('#modalFormEnterpriseEdit').modal('show');
    }
}

function fntDelEnterprise(idEnterprise){
    Swal.fire({
        title: "Elimnar empresa",
        text: "¿Realmente quiere eliminar la empresa?",
        icon: "warning", // En SweetAlert2 se usa "icon" en lugar de "type"
        showCancelButton: true,
        confirmButtonText: "Si, Eliminar!",
        cancelButtonText: "No, Cancelar!",
        reverseButtons: true // Opcional, para invertir el orden de los botones
    }).then((result) => {
        if (result.isConfirmed) {
            // Aquí va la lógica para hacer la solicitud XMLHttpRequest
            let request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
            let ajaxUrl = base_url + '/Enterprise/delEnterprise';
            let strData = "idEnterprise=" + idEnterprise;
            request.open("POST", ajaxUrl, true);
            request.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
            request.send(strData);
            request.onreadystatechange = function() {
                if (request.readyState == 4 && request.status == 200) {
                    let objData = JSON.parse(request.responseText);
                    if (objData.status) {
                        Swal.fire("Eliminado!", objData.msg, "success");
                        tableEnterprises.api().ajax.reload();
                    } else {
                        Swal.fire("Atención!", objData.msg, "error");
                    }
                }
            }
        } else if (result.dismiss === Swal.DismissReason.cancel) {
            Swal.fire("Cancelado", "La empresa no se pudo eliminar.", "error");
        }
    });

}

function openModal()
{
    document.querySelector("#formEnterprise").reset();
    $('#modalFormEnterprise').modal('show');
}

function generateToken(){

    function random() {
    return Math.random().toString(36).substr(2); // Eliminar `0.`
    };
 
    function token() {
    return random() +random()+'-'+ random()+random() +'-'+ random()+random() +'-'+ random()+random();
    };
 
    document.querySelector('#tokenpanel').value =token();
}