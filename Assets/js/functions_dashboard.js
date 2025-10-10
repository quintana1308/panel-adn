let tableDashboard;
const base_url = document.getElementById('url').dataset.value;
let rowTable = "";
let divLoading = document.querySelector("#divLoading");
document.addEventListener('DOMContentLoaded', function(){

    tableDashboard = $('#tableDashboard').dataTable( { 
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
            "url": " "+base_url+"/Dashboard/getDashboards",
            "dataSrc":""
        },
        "columns":[
            {"data":"ID_DASHBOARD"},
            {"data":"DESCRIPCION"},
            {"data":"BD"},
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

    if(document.querySelector("#formDashboard")){
        let formDashboard = document.querySelector("#formDashboard");
        formDashboard.onsubmit = function(e) {
            e.preventDefault();
            //let intIdKpi = document.querySelector('#intIdKpi').value;
            let descripcion = document.querySelector('#descripcion').value;
            let baseDeDatos = document.querySelector('#baseDeDatos').value;

            if(descripcion == '' || baseDeDatos == '')
            {
                Swal.fire("Atención", "Todos los campos son obligatorios" , "error");
                return false;
            }

            divLoading.style.display = "flex";
            let request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
            let ajaxUrl = base_url+'/Dashboard/setDashboard'; 
            let formData = new FormData(formDashboard);
            request.open("POST",ajaxUrl,true);
            request.send(formData);


            request.onreadystatechange = function(){
                if(request.readyState == 4 && request.status == 200){
                    let objData = JSON.parse(request.responseText);
                    if(objData.status)
                    {   
                        divLoading.style.display = "none";
                        $('#modalFormDashboard').modal("hide");
                        formDashboard.reset();
                        Swal.fire("Dashboard", objData.msg ,"success");
                        tableDashboard.api().ajax.reload();
                    }else{
                        Swal.fire("Error", objData.msg , "error");
                    }
                }
                return false;
            }
        }
    }

    if(document.querySelector("#formDashboardClonar")){
        let formDashboard = document.querySelector("#formDashboardClonar");
        formDashboard.onsubmit = function(e) {
            e.preventDefault();

            let descripcion = document.querySelector('#descripcionClonar').value;
            let baseDeDatos = document.querySelector('#baseDeDatosClonar').value;

            if(descripcion == '' || baseDeDatos == '')
            {
                Swal.fire("Atención", "Todos los campos son obligatorios" , "error");
                return false;
            }

            divLoading.style.display = "flex";
            let request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
            let ajaxUrl = base_url+'/Dashboard/duplicateDashboard'; 
            let formData = new FormData(formDashboard);
            request.open("POST",ajaxUrl,true);
            request.send(formData);


            request.onreadystatechange = function(){
                if(request.readyState == 4 && request.status == 200){
                    let objData = JSON.parse(request.responseText);
                    if(objData.status)
                    {
                        divLoading.style.display = "none";
                        $('#modalFormDashboardClonar').modal("hide");
                        formDashboard.reset();
                        Swal.fire("Dashboard Clonado", objData.msg ,"success");
                        tableDashboard.api().ajax.reload();
                    }else{
                        Swal.fire("Error", objData.msg , "error");
                    }
                }
                return false;
            }
        }
    }
}, false);

function fntDuplicateDashboard(dashboard){
    let idDashboard = dashboard;
    Swal.fire({
        title: "Clonar Dashboard",
        text: "¿Realmente quiere clonar el dashboard?",
        type: "warning",
        showCancelButton: true,
        confirmButtonText: "Si, clonar!",
        cancelButtonText: "No, cancelar!",
        closeOnConfirm: false,
        closeOnCancel: true
    }, function(isConfirm) {
        
        if (isConfirm) 
        {
            let request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
            let ajaxUrl = base_url+'/Dashboard/duplicateDashboard';
            let strData = "idDashboard="+idDashboard;
            request.open("POST",ajaxUrl,true);
            request.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
            request.send(strData);


            request.onreadystatechange = function(){
                if(request.readyState == 4 && request.status == 200){
                    let objData = JSON.parse(request.responseText);
                    if(objData.status)
                    {
                        Swal.fire("Clonado Correctamente!", objData.msg , "success");
                        tableDashboard.api().ajax.reload();
                    }else{
                        Swal.fire("Atención!", objData.msg , "error");
                    }
                }
            }
        }

    });

}

/*function fntViewDashboard(idDashboard){
    let request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
    let ajaxUrl = base_url+'/Dashboard/getDashboard/'+idDashboard;
    request.open("GET",ajaxUrl,true);
    request.send();
    request.onreadystatechange = function(){
        if(request.readyState == 4 && request.status == 200){
            let objData = JSON.parse(request.responseText);

            if(objData.status)
            {
                document.querySelector("#celIdDashboard").innerHTML = objData.data.ID_DASHBOARD;
                document.querySelector("#celKpis").innerHTML = objData.data.KPIS;
               
                $('#modalViewDashboard').modal('show');
            }else{
                Swal.fire("Error", objData.msg , "error");
            }
        }
    }
}*/

/*function fntDelDashboard (dashboard){
    let idDashboard = dashboard;
    Swal.fire({
        title: "Eliminar Dashboard",
        text: "¿Realmente quiere Eliminar el dashboard y sus Kpis?",
        type: "warning",
        showCancelButton: true,
        confirmButtonText: "Si, Eliminar!",
        cancelButtonText: "No, cancelar!",
        closeOnConfirm: false,
        closeOnCancel: true
    }, function(isConfirm) {
        
        if (isConfirm) 
        {
            let request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
            let ajaxUrl = base_url+'/Dashboard/delDashboard/'+idDashboard;
            let strData = "idDashboard="+idDashboard;
            request.open("POST",ajaxUrl,true);
            request.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
            request.send(strData);


            request.onreadystatechange = function(){
                if(request.readyState == 4 && request.status == 200){
                    let objData = JSON.parse(request.responseText);
                    if(objData.status)
                    {
                        Swal.fire("Eliminado Correcteamente!", objData.msg , "success");
                        tableDashboard.api().ajax.reload();
                    }else{
                        Swal.fire("Atención!", objData.msg , "error");
                    }
                }
            }
        }

    });

}*/



/*function fntKpiDashboard(dashboard){
    var idDashboard = dashboard;
    var request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
    var ajaxUrl = base_url+'/Dashboard/getDashboardKpi/'+idDashboard;
    request.open("GET",ajaxUrl,true);
    request.send();

    request.onreadystatechange = function(){
        if(request.readyState == 4 && request.status == 200){
            document.querySelector('#contentAjax').innerHTML = request.responseText;
            $('.modalDashboardKpi').modal('show');
            document.querySelector('#formDashboardKpi').addEventListener('submit',fntSaveDashboardKpi,false);
        }
    }
}*/

/*function fntSaveDashboardKpi(evnet){
    evnet.preventDefault();
    var request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
    var ajaxUrl = base_url+'/Dashboard/setDashboardKpi'; 
    var formElement = document.querySelector("#formDashboardKpi");
    var formData = new FormData(formElement);
    request.open("POST",ajaxUrl,true);
    request.send(formData);

    request.onreadystatechange = function(){
        if(request.readyState == 4 && request.status == 200){
            var objData = JSON.parse(request.responseText);
            if(objData.status)
            {   
                $('#formDashboardKpi').modal("hide");
                        formElement.reset();
                        Swal.fire("Dashboard", objData.msg ,"success");
                        tableDashboard.api().ajax.reload();
            }else{
                Swal.fire("Error", objData.msg , "error");
            }
        }
    }
}*/

function openModal()
{
    $('#modalFormDashboard').modal('show');
}

function openModalClonar($idDashboard)
{       
    fetch('Config/getServers.php')
        .then(response => response.json())
        .then(data => {
            const selectElement = document.getElementById('servidorClonar');
            data.forEach(server => {

                console.log(server);
                const option = document.createElement('option');
                option.value = `${server.host},${server.database},${server.username},${server.password}`;
                option.textContent = server.label;
                selectElement.appendChild(option);
            });
        })
        .catch(error => console.error('Error al cargar servidores:', error));

    document.querySelector("#idDashboardClonar").value = $idDashboard;
    $('#modalFormDashboardClonar').modal('show');
}
