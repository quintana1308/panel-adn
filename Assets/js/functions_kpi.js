let tableKpi;
let divLoading = document.querySelector("#divLoading");
document.addEventListener('DOMContentLoaded', function(){

    tableKpi = $('#tableKpi').dataTable( {
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
            "url": " "+base_url+"/Kpi/getKpis",
            "dataSrc":""
        },
        "columns":[
            {"data":"ID_KPI"},
            {"data":"ID_KPI_DD"},
            {"data":"LABEL"},
            {"data":"DESCRIPTION"},
            {"data":"OCULTO"},
            {"data":"POSICION"},
            {"data":"options"}
        ],
        "resonsieve":"true",
        "bDestroy": true,
        "iDisplayLength": 100,
        "order":[[0,"asc"]]  
    });

     if(document.querySelector("#formKpi")){
        let formKpi = document.querySelector("#formKpi");
        formKpi.onsubmit = function(e) {
            e.preventDefault();
            //let intIdKpi = document.querySelector('#intIdKpi').value;
            let intIdKpiDD = document.querySelector('#intIdKpiDD').value;
            let intIdKpiPadre = document.querySelector('#intIdKpiPadre').value;
            let strLabel = document.querySelector('#txtLabel').value;
            let strDescription = document.querySelector('#txtDescription').value;
            let strSqlValue = document.querySelector('#txtSqlValue').value;
            let strSqlTaba = document.querySelector('#txtSqlTabla').value;
            let intOculto = document.querySelector('#intOculto').value;
            let strTotalizar = document.querySelector('#txtTotalizar').value;
            let strIcon = document.querySelector('#txtIcon').value;
            let intModulo = document.querySelector('#intModulo').value;
            let intPosicion = document.querySelector('#intPosicion').value;
            let intGraficaPrincipal = document.querySelector('#intGraficaPrincipal').value;
            let intIdGrafica = document.querySelector('#listIdGrafica').value;
            let strParam1 = document.querySelector('#txtParam1').value;
            let strParam2 = document.querySelector('#txtParam2').value;
            let strParam3 = document.querySelector('#txtParam3').value;
            let strParam4 = document.querySelector('#txtParam4').value;
            let strParam5 = document.querySelector('#txtParam5').value;
            let strUpd = document.querySelector('#txtUpd').value;



            if(intIdKpi == ''  || strLabel == '' || strDescription == '' || strSqlValue == '' || strSqlTaba == '' || intOculto == '' || intModulo == '')
            {
                Swal.fire("Atención", "Todos los campos son obligatorios." , "error");
                return false;
            }

            let elementsValid = document.getElementsByClassName("valid");
            for (let i = 0; i < elementsValid.length; i++) { 
                if(elementsValid[i].classList.contains('is-invalid')) { 
                    Swal.fire("Atención", "Por favor verifique los campos en rojo." , "error");
                    return false;
                } 
            } 
            divLoading.style.display = "flex";
            let request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
            let ajaxUrl = base_url+'/kpi/setKpi'; 
            let formData = new FormData(formKpi);
            request.open("POST",ajaxUrl,true);
            request.send(formData);


            request.onreadystatechange = function(){
                if(request.readyState == 4 && request.status == 200){
                    let objData = JSON.parse(request.responseText);
                    if(objData.status)
                    {
                        $('#modalFormKpi').modal("hide");
                        formKpi.reset();
                        Swal.fire("Kpi", objData.msg ,"success");
                        tableKpi.api().ajax.reload();
                    }else{
                        Swal.fire("Error", objData.msg , "error");
                    }
                }
                divLoading.style.display = "none";
                return false;
            }
        }
    }

}, false);

function fntEditKpi(element,idKpi){
    rowTable = element.parentNode.parentNode.parentNode; 
    document.querySelector('#titleModal').innerHTML ="Actualizar Kpi";
    document.querySelector('.modal-header').classList.replace("headerRegister", "headerUpdate");
    document.querySelector('#btnActionForm').classList.replace("btn-primary", "btn-info");
    document.querySelector('#btnText').innerHTML ="Actualizar";

    let request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
    let ajaxUrl = base_url+'/kpi/getKpi/'+idKpi;
    request.open("GET",ajaxUrl,true);
    request.send();
    request.onreadystatechange = function(){

        if(request.readyState == 4 && request.status == 200){
            let objData = JSON.parse(request.responseText);

            if(objData.status)
            {
                document.querySelector('#id').value =objData.data.ID_KPI;;
                document.querySelector('#intIdKpi').value = objData.data.ID_KPI;
                document.querySelector("#intIdKpiDD").value = objData.data.ID_KPI_DD;
                document.querySelector("#intIdKpiPadre").disabled = true;
                document.querySelector("#txtLabel").value = objData.data.LABEL;
                document.querySelector("#txtDescription").value =objData.data.DESCRIPTION;
                document.querySelector('#txtSqlValue').value = objData.data.SQL_VALUE;
                document.querySelector("#txtSqlTabla").value = objData.data.SQL_TABLA;
                document.querySelector("#intOculto").value = objData.data.OCULTO;
                document.querySelector("#txtTotalizar").value =objData.data.TOTALIZAR;
                document.querySelector("#txtIcon").value = objData.data.ICON;
                document.querySelector("#intModulo").value =objData.data.MODULO;
                document.querySelector("#intPosicion").value =objData.data.POSICION;
                document.querySelector("#intGraficaPrincipal").value =objData.data.GRAFICA_PRINCIPAL;
                document.querySelector("#listIdGrafica").value =objData.data.ID_GRAFICA;
                document.querySelector("#txtParam1").value =objData.data.PARAM1;
                document.querySelector("#txtParam2").value =objData.data.PARAM2;
                document.querySelector("#txtParam3").value =objData.data.PARAM3;
                document.querySelector("#txtParam4").value =objData.data.PARAM4;
                document.querySelector("#txtParam5").value =objData.data.PARAM5;
                document.querySelector("#txtUpd").value =objData.data.UPD;
            }
        }    
    
        $('#modalFormKpi').modal('show');
    }   
}

function fntDelKpi(idKpi){
    var idKpi = idKpi;
    Swal.fire({
        title: "Eliminar Kpi",
        text: "¿Realmente quiere eliminar el Kpi?",
        type: "warning",
        showCancelButton: true,
        confirmButtonText: "Si, eliminar!",
        cancelButtonText: "No, cancelar!",
        closeOnConfirm: false,
        closeOnCancel: true
    }, function(isConfirm) {
        
        if (isConfirm) 
        {
            var request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
            var ajaxUrl = base_url+'/kpi/delKpi/';
            var strData = "idKpi="+idKpi;
            request.open("POST",ajaxUrl,true);
            request.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
            request.send(strData);
            request.onreadystatechange = function(){
                if(request.readyState == 4 && request.status == 200){
                    var objData = JSON.parse(request.responseText);
                    if(objData.status)
                    {
                        Swal.fire("Eliminar!", objData.msg , "success");
                        tableKpi.api().ajax.reload(function(){
                            //fntEditRol();
                            //fntDelRol();
                            //fntPermisos();
                        });
                    }else{
                        Swal.fire("Atención!", objData.msg , "error");
                    }
                }
            }
        }

    });
}



function openModal()
{
    document.querySelector('#id').value ="";
    document.querySelector('.modal-header').classList.replace("headerUpdate", "headerRegister");
    document.querySelector('#btnActionForm').classList.replace("btn-info", "btn-primary");
    document.querySelector('#btnText').innerHTML ="Guardar";
    document.querySelector('#titleModal').innerHTML = "Nuevo Kpi";
    document.querySelector("#intIdKpiPadre").disabled = false;
    document.querySelector("#formKpi").reset();
    $('#modalFormKpi').modal('show');
}
