    <?php 
    /** 
     * este archivo se encarga de la informcaión de cada kpi,
     * mostramos la tabla con la información cada kpi tanto el pricipal como sus profundidades
     * a su vez si el kpi posee grafica se habilita un botonn desde el datatables para mostrar dicha grafica
     * tecnicamente es el archivo mas importante ya que es el que contiene los datos relevantes para el cliente
     * */
    headerCliente($data);
    getModal('modalGraficaTabla',$data);

    $arrKpi = $data['kpi']; // obtenemos los datos del kpi 

    $filter_status = $arrKpi['FILTER'];

    $arrOcultar = empty($arrKpi['OCULTAR'])? array(): explode(",", $arrKpi['OCULTAR']); //arreglo que contiene las columnas que deben totalizar

    /*OCULTAR CAMPOS*/
    for($i = 0; $i < count($arrKpi['SQL_TABLA']); $i++){

        $j=1;	
        foreach($arrKpi['SQL_TABLA'][$i] as $key => $value) {
            if(in_array($j, $arrOcultar)){
                unset($arrKpi['SQL_TABLA'][$i][$key]);
            }
            $j++;
        }
    }

    $tbody=$arrKpi['SQL_TABLA']; // obtenemos los datos que trae la consulta del campo sql_tabla 
    $kpi = $arrKpi['ID_KPI']; // id del kpi
    $kpiDD = $arrKpi['ID_KPI_DD']; // id del kpi el cual profundiza
    $grafica = $arrKpi['ID_GRAFICA']; // almacenamos el id de la grafica, si no posee grafica su valor es 0, 1 grafica tipo line, 2 grafica tipo pie

    $arrTotalizar = empty($arrKpi['TOTALIZAR'])? array(): explode(",", $arrKpi['TOTALIZAR']); //arreglo que contiene las columnas que deben totalizar

    ?>
    <script>
    // Verificar si la pestaña tiene un identificador único
    if (!window.name || window.name === '') {
            window.name = 'tab_' + Math.random().toString(36).substr(2, 9);
        }
        
        // Definir la clave de almacenamiento para la pestaña actual
        const tabKey = `breadcrumbs_${window.name}`;
        let breadcrumbs = JSON.parse(localStorage.getItem(tabKey)) || [];
        
        // Definir el Home y Módulo como fijos
        const homeBreadcrumb = { 
            ruta: "<?= base_url(); ?>/home", 
            label: '<i class="fas fa-home"></i>' 
        };
        const moduleBreadcrumb = { 
            ruta: "<?= base_url(); ?>/home/<?= $_SESSION['modulo']; ?>", 
            label: "<?= ucwords($_SESSION['modulo']); ?>"
        };
        
        // Capturar la ruta y la profundidad actual
        const currentBreadcrumb = {
            ruta: "<?= base_url().$_SERVER['REQUEST_URI']; ?>",
            label: "<?= $arrKpi['LABEL']; ?>"
        };
        
        // Asegurar que Home y Módulo estén siempre presentes
        if (breadcrumbs.length === 0) {
            breadcrumbs.push(homeBreadcrumb, moduleBreadcrumb);
        }
        
        // Si la ruta actual ya existe, eliminar las siguientes profundidades
        const existingIndex = breadcrumbs.findIndex(b => b.ruta === currentBreadcrumb.ruta);
        if (existingIndex !== -1) {
            breadcrumbs = breadcrumbs.slice(0, existingIndex + 1); // Mantener hasta la ruta seleccionada
        } else {
            // Si es una nueva profundidad, agregarla al final
            breadcrumbs.push(currentBreadcrumb);
        }
        
        // Guardar los breadcrumbs actualizados en Local Storage
        localStorage.setItem(tabKey, JSON.stringify(breadcrumbs));
        
        // Renderizar los breadcrumbs con la nueva lógica
        function renderBreadcrumbs() {
            const breadcrumbContainer = document.getElementById('breadcrumb-list');

            breadcrumbContainer.innerHTML = '';
        
            breadcrumbs.forEach((breadcrumb, index) => {
                if (index === breadcrumbs.length - 1) {
                    breadcrumbContainer.innerHTML += `<li class="breadcrumb-item active" aria-current="page">${breadcrumb.label}</li>`;
                } else {
                    breadcrumbContainer.innerHTML += `
                        <li class="breadcrumb-item">
                            <a href="${breadcrumb.ruta}" onclick="navigateToBreadcrumb('${breadcrumb.ruta}')">${breadcrumb.label}</a>
                        </li>`;
                }
            });
        }
        
        // Función para manejar la navegación al hacer clic en un breadcrumb
        function navigateToBreadcrumb(ruta) {
            const index = breadcrumbs.findIndex(b => b.ruta === ruta);
            if (index !== -1) {
                breadcrumbs = breadcrumbs.slice(0, index + 1);
                localStorage.setItem(tabKey, JSON.stringify(breadcrumbs));
                window.location.href = ruta; // Redireccionar a la ruta seleccionada
            }
        }
        
        window.onload = renderBreadcrumbs;
        </script>
    <?php if ($filter_status == 0) { ?>
    <div class="container-fluid">
        <nav aria-label="breadcrumb" class="mt-3 mr-3 ml-3">
            <ol id="breadcrumb-list" class="breadcrumb card" style="flex-direction: initial !important;"></ol>
        </nav>
    </div>
    <?php }else{ ?>
        <div class="container-fluid">
            <nav aria-label="breadcrumb" class="mt-3 mr-3 ml-3">
                <ol class="breadcrumb card" style="flex-direction: initial !important;">
                    <li class="breadcrumb-item active" aria-current="page"><a href="<?= base_url() ?>"><i class="fas fa-home"></i></a></li>
                    <li class="breadcrumb-item" aria-current="page">Ventas</li>
                    <li class="breadcrumb-item">Centro de datos Financieros</li>
                </ol>
            </nav>
        </div>
    <?php } ?>
    <?php 
    if ($filter_status == 0) {
    if ($tbody == NULL) {
        echo '<div class="alert alert-warning alert-dismissible fade show" role="alert" style="margin:20px 20px">
        <strong>Atención!</strong> No hay datos para mostrar...
        </div>';

    }
    }
    ?>

    <div class="header  pb-6">
        <div class="container-fluid" style="margin-top: 30px;">
            <div class="header-body">
                <div class="row mb-4">
                    <div class="col-md-12">
                        <?php if (!empty($data['filtros'])) { ?>
                        <div class="card d-flex">
                            <div class="card-header p-2 d-flex">
                                <h3>Filtros</h3>
                                <a href="#" class="bg-info p-2 text-white rounded px-3 ps-3 mx-2" id="cwhere"> <i
                                        class="fa-solid fa-rotate-right"></i></a>
                            </div>
                            <div class="card-body ">
                                <form action="#" method="get" id="form-filter">
                                    <div class="row">
                                        <div class="col-md-3">
                                            <label class="form-control-label">TIPO : </label>
                                            <select class="form-control class-kpi" id="KPI" name="KPI">
                                                <option selected disabled data-atributo='hola'>--- Seleccione ---</option>
                                                <?php foreach ($data['filtros'][0]['SQL_SINCE'] as $key => $condic) { ?>
                                                <option value="<?= $condic['INDICE'] ?>"
                                                    data-atributo="<?= $condic['FILTER'] ?>"
                                                    data-atributo-access="<?= $condic['FILTER_ACCESS'] ?>">
                                                    <?= $condic['VALOR'] ?></option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                        <?php 
                                        foreach ($data['filtros'] as $key => $filtro) { ?>

                                        <?php if ($key != 0) { ?>
                                        <div class="col-md-3">
                                            <?php if ($filtro['TYPE_PARAM'] == 'SELECT') { ?>
                                            <label class="form-control-label"><?= $filtro['LABEL'] ?> : </label>
                                            <select
                                                class="form-control js-example-basic-multiple js-example-basic-multiple filter-<?= $filtro['ORDER_PARAM'] ?>"
                                                id="<?= $filtro['NAME_COLUMN'] ?>" name="<?= $filtro['NAME_COLUMN'] ?>"
                                                multiple="multiple">

                                                <option selected disabled>--- Seleccione ---</option>

                                                <?php foreach ($filtro['SQL_SINCE'] as $key => $condic) { ?>
                                                <option value="^<?= $condic['INDICE'] ?>"><?= $condic['VALOR'] ?> </option>
                                                <?php } ?>
                                            </select>

                                            <?php } else if ($filtro['TYPE_PARAM'] == 'DATE') { ?>
                                            <label class="form-control-label"><?= $filtro['LABEL'] ?> :</label>
                                            <input type="<?= $filtro['TYPE_PARAM'] ?>" name="<?= $filtro['NAME_COLUMN'] ?>"
                                                value="<?= date('Y-m-d') ?>"
                                                class="form-control p-2 form-filter-date filter-<?= $filtro['ORDER_PARAM'] ?>">

                                            <?php } ?>

                                        </div>
                                        <?php } ?>
                                        <?php } ?>
                                        <div class="col-md-3 mt-4">
                                            <a href="#" class="btn btn-success" id="btn-filter">
                                                <i class="fa fa-fw fa-lg fa-filter"></i> Filtrar</a>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <?php } ?>
                    </div>
                </div>
                <?php if ($grafica == 13 && !empty($data['paramsMap']['PARAM2'])) { ?>
                    <center>
                        <div id="map"></div>
                        <div id="legendContent">
                        </div>
                    </center>
                <?php } ?>

                <!-- Card stats -->
                <?php if (!empty($tbody)) { ?>
                <div class="row">
                    <div class="col">
                        <div class="card">
                            <!-- Card header -->
                            <div class="card-header border-0">
                                <h6 class="mb-0"><?= $arrKpi['LABEL']; ?></h6>
                                <small class="mb-0 text-gray"><?= $arrKpi['UPD']; ?></small>
                            </div>

                            <!-- Light table -->
                            <div class="table-responsive ">
                                <table class="display table table-hover table-sm table-striped" id="tabla" style="width:100%">

                                    <thead>
                                        <tr>
                                            <?php 
                                            unset($arrKpi['SQL_TABLA'][0]['CWHERE']); //eliminamos del arreglo el campo cwhere para que no se muestre en el thead
                                            $thead = array_keys($arrKpi['SQL_TABLA'][0]); // obtenemos las keys del arreglo que corresponde a cada thead

                                            for ($i=0; $i < count($thead); $i++) { 
                                                
                                            ?>

                                            <th scope="col" style="font-weight: bold; font-size: 0.73em;"><?= $thead[$i]; ?>
                                            </th>

                                            <?php } ?>
                                        </tr>
                                    </thead>
                                    <tbody>

                                        <?php for ($j=0; $j <count($tbody) ; $j++) { //recorremos los datos que trae la consulta del campo sql_tabla, arrmamos cada fila y la llenamos con los datos
                                            $cwhere = !empty($tbody[$j]['CWHERE'])?$tbody[$j]['CWHERE']:''; //almacenamos el cwhere antes de eliminarlo del arreglo para que no se muestre en la tabla
                                            unset($tbody[$j]['CWHERE']);// eliminamos el cwhere del arreglo
                                            ?>

                                        <?php 
                                                if($cwhere AND  $arrKpi['ID_KPI_DD'] !== NULL){  
                                                    /**condicion para saber si el kpi tiene profundidad 
                                                     * si el campo tiene profundidad arma la ruta que lo lleva al metodo kpi del controlador kpi  y recibe como parametro el id_kpi_dd, 
                                                     * el cual lo redirecciona a este mismo archivo pero mostrando como kpi principal(id_kpi) el kpi_dd.
                                                     * si no tiene profundidad solo muestra la fila.
                                                     */
                                                ?>
                                        <tr onclick="window.location=`<?= base_url(); ?>/tabla/kpi/<?= $kpiDD.'?where='.$cwhere?>`"
                                            style="cursor:pointer; font-size: 0.83em;">

                                            <?php } else { ?>

                                        <tr style="font-size:0.83em">

                                            <?php } ?>

                                            <?php 
                                                    /** 
                                                     * recorremos con un foreach para obtener los datos de cada posicion del arreglo 
                                                     * y llenamos cada columna con los datos correspondientes
                                                     * si solo retorna numeros, aplicamos un formato numerico y lo alineamos a la derecha
                                                     * de lo contrario lo alineamos a la izquierda
                                                     * */
                                                    $x = 0;// esta variable es para que el campo que esta en la primera posicion se mantenga en string 
                                                    foreach ($tbody[$j] as $key => $row) { 
                                                        $x++;
                                                        if(is_numeric($row) && $x != 1 && $key != 'DOCUMENTO' && $key != 'CLIENTE' && $key != 'CODIGO' && $key != 'NUMERO' && $key != 'LATITUD' && $key != 'LONGITUD'){
                                                            $row = number_format($row,2);

                                                            if(empty($data['formato_condicional'])){
                                                                echo '<td align="right">'.$row.'</td>';
                                                            }else{ 
                                                                $style = '';
                                                                // Validar condiciones activas
                                                                foreach ($data['formato_condicional'] as $key2 => $condicion) {
                                                                    if ($condicion["ACTIVO"] == 1 && $key == $condicion["COLUMNA"]) {
                                                                        // Evaluación dinámica de la condición
                                                                        $valueLimpio = floatval(str_replace(',', '', $row));
                                                                        $valorComparacion = floatval($condicion['VALOR']);
                                                                        $cumpleCondicion = false;
                                                                        
                                                                        // Validación del tipo de condición
                                                                        if ($condicion["TIPO"] == "RANGO") {
                                                                            // Si es de tipo RANGO, verifica si está entre MINIMO y MAXIMO
                                                                            $minimo = floatval($condicion['MINIMO']);
                                                                            $maximo = floatval($condicion['MAXIMO']);

                                                                            if ($valueLimpio >= $minimo && $valueLimpio <= $maximo) {
                                                                                $cumpleCondicion = true;
                                                                            }
                                                                        } elseif ($condicion["TIPO"] == "CONDICION") {
                                                                            // Si es de tipo CONDICION, aplicar comparaciones normales
                                                                            switch ($condicion['CONDICION']) {
                                                                                case '>':
                                                                                    $cumpleCondicion = $valueLimpio > $valorComparacion;
                                                                                    break;
                                                                                case '>=':
                                                                                    $cumpleCondicion = $valueLimpio >= $valorComparacion;
                                                                                    break;
                                                                                case '<':
                                                                                    $cumpleCondicion = $valueLimpio < $valorComparacion;
                                                                                    break;
                                                                                case '<=':
                                                                                    $cumpleCondicion = $valueLimpio <= $valorComparacion;
                                                                                    break;
                                                                                case '==':
                                                                                    $cumpleCondicion = $valueLimpio == $valorComparacion;
                                                                                    break;
                                                                                case '!=':
                                                                                    $cumpleCondicion = $valueLimpio != $valorComparacion;
                                                                                    break;
                                                                                default:
                                                                                    echo "Condición no válida.";
                                                                                    break;
                                                                            }
                                                                        }
                                                                        
                                                                        // Evaluación final
                                                                        if ($cumpleCondicion) {
                                                                            $color = $condicion["HEXADECIMAL"];
                                                                            $style='style="color:'.$color.' !important;"';
                                                                        }
                                                                    }
                                                                }
                                                                echo '<td align="right" '.$style.'>'.$row.'</td>';
                                                            } 
                                                            
                                                        } else {
                                                            echo '<td align="left">'.$row.'</td>';
                                                        }
                                                        ?>


                                            <?php } ?>
                                        </tr>

                                        <?php } ?>

                                    </tbody>
                                    <tfoot align="right">
                                        <tr>
                                            <?php 
                                                //arrmamaos el tfoot con la misma cantidad de campos que el thead y precedemos a llenarlos con una funcion desde el datatables
                                                for ($i=0; $i <count($thead); $i++) { ?>

                                            <th style="font-size: 0.9em;font-weight: bold;"></th>

                                            <?php } ?>
                                        </tr>
                                    </tfoot>


                                </table>
                            </div>
                            <!-- Card footer -->

                        </div>
                    </div>
                </div>
                <?php } ?>
            </div>
        </div>
    </div>





    <?php footerCliente($data); ?>

    <script src="//cdnjs.cloudflare.com/ajax/libs/numeral.js/2.0.6/numeral.min.js"></script>


    <script type="text/javascript">
    var tabla;
    var url_p1 = '';

    $(document).ready(function(e) {
        /*=============== RECUPERAR FILTROS Y VALORES ACTIVOS ===================*/
        var guardados = localStorage.getItem('datosFormulario');

        if (guardados) {
            guardados = JSON.parse(guardados);
            // LLENA LOS CAMPOS CON LOS VALORES QUE SE HABIAN SELECCIONADO
            $.each(guardados, function(key, value) {
                $('[name="' + key + '"]').val(value);
            });
            // DESACTIVA LOS FILTROS QUE NO SE ESTABAN USANDO
            $('.class-kpi').each(function(index) {
                let condition_filter_inherited = $(this).find(':selected').data('atributo').split(',');
                $(condition_filter_inherited).each(function(index, value) {
                    $(".filter-" + value + "").prop('disabled', true);
                });
            });
        }

        $('.js-example-basic-multiple').select2();


        /*=============== EVENTO QUE OBTIENE LOS VALORES DE LOS FILTROS Y LOS PROCESA ===================*/
        formData = $('#btn-filter').on('click', function(e) {
            e.preventDefault();
            let com = 0;
            let datos = {};
            let pro = {};
            let new_url = '';
            let kpi = $('#KPI').val();

            localStorage.setItem('datosFormulario', null);

            $('.form-filter-date').each(function(index) {
                if ($(this).val() != '') {
                    url_p1 += $(this).attr('name') + "='" + $(this).val() + "'";
                }
                if (index - 1) {
                    url_p1 += ' AND '
                }
            });

            $('.js-example-basic-multiple').each(function(index) {
                if ($(this).val() != '') {
                    url_p1 += ' AND ' + $(this).attr('name') + " RLIKE '" + $(this).val() + "'";
                    url_p1 = url_p1.replace(/,/g, '|');
                }
                com += 1;
            });

            $('#form-filter :input').each(function() {
                if ($(this).attr('name') != undefined) {
                    datos[$(this).attr('name')] = $(this).val();
                }
            });

            localStorage.setItem('datosFormulario', JSON.stringify(datos));
            new_url = "<?php echo base_url() ?>/tabla/kpi/" + kpi + "?where= " + url_p1;
            
            console.log(url_p1);
            console.log(new_url);
            window.location.href = new_url;
        });

    });

    /*=============== EVENTO PARA ACTIVAR Y DESACTIVAR FILTROS SEGÚN EL TIPO===================*/
    $('.class-kpi').change(function(index) {

        let condition_filter = $(this).find(':selected').data('atributo').split(',');
        let condition_filter_access = $(this).find(':selected').data('atributo-access').split(',');

        $(condition_filter).each(function(index, value) {
            $(".filter-" + value + "").prop('disabled', true);
            $(".filter-" + value + "").val(null).trigger('change');
        });
        $(condition_filter_access).each(function(index, value) {
            $(".filter-" + value + "").prop('disabled', false);
        });

    });


    $('#cwhere').click(function(e) {
        e.preventDefault();
        let url_cwhere = '';
        let com = 0;
        let kpi = $('#KPI').val();

        $('.form-filter-date').each(function(index) {
            if ($(this).val() != '') {
                url_cwhere += $(this).attr('name') + "='" + $(this).val() + "'";
            }
            if (index - 1) {
                url_cwhere += ' AND '
            }
        });

        $('.js-example-basic-multiple').each(function(index) {
            if ($(this).val() != '') {
                url_cwhere += ' AND ' + $(this).attr('name') + " RLIKE '" + $(this).val() + "'";
                url_cwhere = url_cwhere.replace(/,/g, '|');
            }
            com += 1;
        });

        console.log(url_cwhere);
    });

    function getBreadcrumbText() {
        let breadcrumbs = document.querySelectorAll("#breadcrumb-list .breadcrumb-item");
        let breadcrumbText = Array.from(breadcrumbs).map(item => item.innerText.trim()).join(" > ");
        return breadcrumbText;
    }

    document.addEventListener('DOMContentLoaded', function() {

        tabla = $('#tabla').dataTable({
            "resposive": true,
            "footerCallback": function(row, data, start, end, display) {
                var api = this.api(),
                    data;
                // converting to interger to find total
                var intVal = function(i) {
                    return typeof i === 'string' ?
                        i.replace(/[\$,]/g, '') * 1 :
                        typeof i === 'number' ?
                        i : 0;
                };

                $(api.column('0').footer()).html('TOTAL');
                <?php
                    for ($i = 0; $i < count($arrTotalizar); $i++) {
                        $var = 'col' . $i;
                        $value = $arrTotalizar[$i] - 1;
                    ?>

                var <?= 'page' . $var; ?> = api
                    .column(<?= $value; ?>, {
                        page: 'current'
                    })
                    .data()
                    .reduce(function(a, b) {

                        let pageTotal = intVal(a) + intVal(b);
                        return numeral(pageTotal).format('0,0.00');
                    }, 0);
                $(api.column(<?= $value; ?>).footer()).html(
                <?= 'page' . $var; ?>); //+ ' (total: '+ <?= $var; ?>+')' total general
                <?php	}	?>
            },
            "rowReorder": {
                "selector": 'td:nth-child(2)'
            },
            "aProcessing": true,
            "aServerSide": true,
            "language": {
                "decimal": ".",
                "thousand": ",",
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
            'dom': 'lBfrtip',
            'lengthMenu': [
                [10, 50, 100, 250, -1],
                ['10', '50', '100', '250', 'Todos']
            ],
            "aaSorting": [], //Agregar o Quitar segun se necesite desactivar orden
            'buttons': [{
                    "extend": "copyHtml5",
                    "text": "<i class='far fa-copy'></i> Copiar",
                    "titleAttr": "Copiar",
                    "className": "btn btn-secondary"
                }
                <?php if($_SESSION['userData']['USERTOKEN'] == '' && $_SESSION['userData']['URL_WEBVIEW'] == '' || $_SESSION['userData']['EXPORT'] == 1) { ?>
                <?php if($_SESSION['userData']['EXPORT'] != 1) {	 ?>
                , {
                    "extend": "excelHtml5",
                    "text": "<i class='fas fa-file-excel'></i> Excel",
                    "titleAttr": "Exportar a excel",
                    <?php if (true) {
                                    echo '"title": "' . $title . '",';
                                } ?> "className": "btn btn-success",
                    "footer": true
                } <?php } ?>
                ,
                {
                    "extend": "pdfHtml5",
                    "text": "<i class='fas fa-file-pdf'></i> PDF",
                    "titleAttr": "exportar a PDF",
                    <?php if (true) {
                                echo '"title": "' . $title . '",';
                            } ?> "className": "btn btn-danger",
                    "orientation": "landscape",
                    "pageSize": "A3",
                    customize: function(doc) {

                        // Obtener la fecha y hora actual
                        var now = new Date();
                        var fechaHora = now.toLocaleDateString() + ' ' + now.toLocaleTimeString();
                        var breadcrumbTitle = getBreadcrumbText();

                        // Agregar el título
                        doc.content.splice(0, 0, {
                            text: breadcrumbTitle, // Asegúrate de definir $title en PHP
                            fontSize: 14,
                            alignment: "center",
                            bold: true,
                            margin: [0, 0, 0, 10]
                        });

                        // Agregar la fecha y hora en la esquina superior izquierda
                        doc.content.splice(1, 0, {
                            text: "Fecha de exportación: " + fechaHora,
                            fontSize: 10,
                            alignment: "center",
                            margin: [0, 0, 0, 40]
                        });

                        // Obtener la tabla original
                        var originalTable = doc.content[doc.content.length - 1];
                        
                        // Ajustar el ancho de las columnas proporcionalmente
                        originalTable.table.widths = 
                            Array(originalTable.table.body[0].length).fill('*');
                        
                        // Envolver la tabla en un layout centrado
                        doc.content[doc.content.length - 1] = {
                            table: {
                                widths: ['*', 'auto', '*'],
                                body: [
                                    ['', originalTable, '']
                                ]
                            },
                            layout: 'noBorders'
                        };

                        // Estilos de tabla
                        doc.styles.tableHeader = {
                            fontSize: 8,
                            fillColor: '#002864',
                            color: '#FFF',
                            bold: true
                        };
                        doc.styles.tableFooter = {
                            fontSize: 8,
                            fillColor: '#002864',
                            color: '#FFF',
                            bold: true
                        };
                        doc.defaultStyle.fontSize = 9;
                    },
                    "footer": true
                }
                <?php } ?>
                <?php if ($grafica != 0 && $grafica != 13) { ?>, {
                    "text": "<i class='fas fa-chart-pie'></i> Gráfica",
                    "titleAttr": "Gráfica",
                    "className": "btn btn-info",
                    action: function(e, dt, node, config) {
                        $('#modalGraficaTabla').modal('show');
                    }
                }
                <?php } ?>

                <?php if ($grafica == 13 && !empty($data['paramsMap']['PARAM2'])) { ?>, {
                    "text": "<i class='fa-solid fa-map'></i> Mapa",
                    "titleAttr": "Mapa",
                    "className": "btn btn-secondary",
                    action: function(e, dt, node, config) {
                        var script = document.createElement('script');
                        script.src =
                            'https://maps.googleapis.com/maps/api/js?key=AIzaSyCYsEXjqibylS7mdxRXk1EJ6KR4O_8Mb54&callback=initMap&v=weekly';
                        script.async = true;
                        let map;
                        let infowindow;
                        let markers = [];
                        var flexMap = document.querySelector('#map');
                        flexMap.style.display = 'flex';
                        function initMap() {
                            <?php
                                echo $data['paramsMap']['PARAM3'][0]['JSON1'];

                                echo "
                                const map = new google.maps.Map(document.getElementById('map'), {
                                    zoom: 6,
                                    center: " . $data['paramsMap']['PARAM2'][0]['POSITION'] . ",
                                });";

                                foreach ($data['paramsMap']['PARAM2'] as $key => $value) {
                                    echo "
                                    let info" . $key . " = '" . $value['INFO'] . "';
                                    const infoWindow" . $key . " = new google.maps.InfoWindow({
                                    content: info" . $key . ",
                                });

                                const marker" . $key . " = new google.maps.Marker({
                                    position: " . $value['POSITION'] . " ,
                                    map: map,
                                    icon: `" . media() . "/img/markers/marker_icon-" . $value['ICON'] . ".svg`,
                                    title: `" . $value['TITLE'] . "`,
                                    optimized: false,
                                });

                                markers.push(marker" . $key . ");
        
                                marker" . $key . ".addListener('click', () => {
                                if (infowindow) {
                                    infowindow.close();
                                }
                                infowindow = infoWindow" . $key . ";
                                infowindow.open({anchor: marker" . $key . "});
                                });";
                                } ?>

                            const legend = document.getElementById("legendContent");

                            legend.classList.add("bg-legend");

                            for (const key in icons) {
                                const type = icons[key];
                                const name = type.name;
                                const icon = type.icon;
                                const div = document.createElement("div");
                                div.innerHTML = '<img src="' + icon + '"> ' + name;
                                legend.appendChild(div);
                            }
                            map.controls[google.maps.ControlPosition.RIGHT_BOTTOM].push(legend);
                        }
                        scroll(0, 100);
                        window.initMap = initMap;

                        document.head.appendChild(script);
                    }
                }
                <?php } ?>
            ],
            "bDestroy": true,
            "iDisplayLength": 100,
        });

    }, false);
    </script>

    <script type="text/javascript">
    <?php if ($grafica == 22) { ?>
    Highcharts.chart('grafico_tabla_line', {
        chart: {
            type: 'line'
        },
        title: {
            text: '<?= $data["paramsLine"]["PARAM1"]; ?>'
        },
        subtitle: {
            text: '<?= $data["paramsLine"]["PARAM2"]; ?>'
        },
        xAxis: {
            categories: [<?= $data['paramsLine']['PARAM3']; ?>]
        },
        yAxis: {
            title: {
                text: ''
            }
        },
        plotOptions: {
            line: {
                dataLabels: {
                    enabled: true
                },
                enableMouseTracking: false
            }
        },
        series: [
            <?php for ($i = 0; $i < count($data['paramsLine']['PARAM5']); $i++) {

                        $x = implode(",", $data['paramsLine']['PARAM5'][$i]);
                        $y = $data['paramsLine']['PARAM4'][$i];

                    ?> {
                <?php echo 'name: ' . "'" . $y . "'" . ','; ?>

                data: [<?= $x; ?>]
            }
            <?php if ($i < count($data['paramsLine']['PARAM5']) - 1) {
                            echo ',';
                        }
                    } ?>
        ]
    });
    <?php } ?>

    <?php if ($grafica == 23) { ?>
    Highcharts.chart('grafico_tabla_pie', {
        chart: {
            plotBackgroundColor: null,
            plotBorderWidth: null,
            plotShadow: false,
            type: 'pie'
        },
        title: {
            text: '<?= $data["paramsPie"]["PARAM1"]; ?>'
        },
        subtitle: {
            text: '<?= $data["paramsPie"]["PARAM2"]; ?>'
        },
        tooltip: {
            pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
        },
        accessibility: {
            point: {
                valueSuffix: '%'
            }
        },
        plotOptions: {
            pie: {
                allowPointSelect: true,
                cursor: 'pointer',
                dataLabels: {
                    enabled: true,
                    format: '<b>{point.name}</b>: {point.percentage:.1f} %'
                }
            }
        },
        series: [{
            name: 'Porcentaje',
            colorByPoint: true,

            data: [
                <?php
                        for ($i = 0; $i < count($data['paramsPie']['PARAM3']); $i++) {
                            echo "{name:'" . $data['paramsPie']['PARAM3'][$i] . "',y:" . $data['paramsPie']['PARAM4'][$i] . "},";
                        }
                        ?>
            ]
        }]
    });
    <?php } ?>

    <?php if ($grafica == 24) { ?>
    Highcharts.chart('grafico_tabla_donut', {
        chart: {
            type: 'pie',
            options3d: {
                enabled: true,
                alpha: 45
            }
        },
        title: {
            text: '<?= $data["paramsDonut"]["PARAM1"]; ?>'
        },
        subtitle: {
            text: '<?= $data["paramsDonut"]["PARAM2"]; ?>'
        },
        plotOptions: {
            pie: {
                innerSize: 100,
                depth: 45
            }
        },
        series: [{
            name: 'Delivered amount',
            data: [
                <?php
                        for ($i = 0; $i < count($data['paramsDonut']['PARAM3']); $i++) {
                            echo "['" . $data['paramsDonut']['PARAM3'][$i] . "', " . $data['paramsDonut']['PARAM4'][$i] . "],";
                        }
                        ?>
            ]
        }]
    });
    <?php } ?>

    <?php if ($grafica == 25) { ?>
    Highcharts.chart('grafico_tabla_column', {
        chart: {
            type: 'column'
        },
        title: {
            text: '<?= $data["paramsColumn"]["PARAM1"]; ?>'
        },
        subtitle: {
            text: '<?= $data["paramsColumn"]["PARAM2"]; ?>'
        },
        xAxis: {
            categories: [<?= $data['paramsColumn']['PARAM3']; ?>],
            crosshair: true
        },
        yAxis: {
            min: 0,
            title: {
                text: ''
            }
        },
        tooltip: {
            headerFormat: '<span style="font-size:10px">{point.key}</span><table>',
            pointFormat: '<tr><td style="color:{series.color};padding:0">{series.name}: </td>' +
                '<td style="padding:0"><b>{point.y:.1f} </b></td></tr>',
            footerFormat: '</table>',
            shared: true,
            useHTML: true
        },
        plotOptions: {
            column: {
                pointPadding: 0.2,
                borderWidth: 0
            }
        },
        series: [

            <?php for ($i = 0; $i < count($data['paramsColumn']['PARAM5']); $i++) {

                        $x = implode(",", $data['paramsColumn']['PARAM5'][$i]);
                        $y = $data['paramsColumn']['PARAM4'][$i];

                    ?> {
                <?php echo 'name: ' . "'" . $y . "'" . ','; ?>

                data: [<?= $x; ?>]
            }
            <?php if ($i < count($data['paramsColumn']['PARAM5']) - 1) {
                            echo ',';
                        }
                    } ?>
        ]
    });
    <?php } ?>
    </script>