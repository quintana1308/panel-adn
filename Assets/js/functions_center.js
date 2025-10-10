document.addEventListener('DOMContentLoaded', function() {
    
    var dataFirst = {
        type: 'line',
        label: "Ventas promedio. A",
        data: [20, 50, 20, 50, 20, 50, 20, 50, 20, 50, 52, 20],
        lineTension: 0.3,
        borderColor: 'rgba(255, 99, 132, 1)',
        backgroundColor: 'rgba(255, 99, 132, 0.2)',
    };
    
    var dataSecond = {
        type: 'bar',
        label: "Proyección. B",
        data: [20, 50, 20, 50, 20, 50, 20, 50, 20, 50, 52, 20],
        borderColor: 'rgba(75, 192, 192, 1)',
        backgroundColor: 'rgba(75, 192, 192, 0.2)',
    };
    
    var speedData = {
        labels: ["enero", "Febrero", "Marzo", "Abril", "Mayo", 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre',
            'Noviembre', 'Diciembre'
        ],
        datasets: [dataFirst, dataSecond]
    };
    
    
    var ctx = document.getElementById('miGrafico').getContext('2d');
    var ctx2 = document.getElementById('miGraficoCompareLine').getContext('2d');
    var ctx3 = document.getElementById('miGraficoCompareBar').getContext('2d');
    var ctx4 = document.getElementById('totalComparative1').getContext('2d');
    
    
    var lineChart = new Chart(ctx, {
        type: 'bar',
        data: speedData
    });
    
    var lineChart2 = new Chart(ctx2, {
        type: 'line',
        data: speedData
    });
    
    var barChart = new Chart(ctx3, {
        type: 'bar',
        data: {
            labels: ["enero", "Febrero", "Marzo", "Abril", "Mayo", 'Junio', 'Julio', 'Agosto', 'Septiembre',
                'Octubre', 'Noviembre', 'Diciembre'
            ],
            datasets: [{
                label: '#Empresa',
                data: [12, 19, 3, 5, 2, 3, 12, 19, 3, 5, 2, 3],
                borderWidth: 1
            }]
        }
    });
    
    
    var TotalbarChart = new Chart(ctx4, {
        type: 'bar',
        data: {
            labels: ["Total Periodo", "Compartiva"],
            datasets: [{
                label: '#Empresa',
                data: [12, 19],
                borderWidth: 1
            }]
        }
    });
    
    
    
    var cant = 0;

    
    $('.js-example-basic-multiple').select2();


    $('.class-kpi').change(function(index) {

        let condition_filter = $(this).find(':selected').data('atributo').split(',');
        let condition_filter_access = $(this).find(':selected').data('atributo-access').split(',');
        let view_compare = ($(this).find(':selected').data('atributo-access')).match('C');
        $(condition_filter).each(function(index, value) {
            $(".filter-" + value + "").prop('disabled', true);
            $(".filter-" + value + "").val(null).trigger('change');

        });
        $(condition_filter_access).each(function(index, value) {
            $(".filter-" + value + "").prop('disabled', false);

        });


        if (view_compare) {

            $('#container-compare').css('display', 'block');
            $('#container-info').css('display', 'none');


        } else {

            $('#container-compare').css('display', 'none');
            $('#container-info').css('display', 'block');
        }



    });

    $('#btn-filter').on('click', function(e) {
        e.preventDefault();
        let com = 0;
        let url_p1 = '';
        let datos = {};
        let pro = {};
        let new_url = '';
        let kpi = $('#KPI').val();
        cant = 0;
        cant = $($("select[name='EMPRESA']").val()).length;
        let head = '';
        head = '<thead> <tr> <td>Variable</td> ';
        head += '<td class="d-none thead -' + cant + '">json0</td> ';
        head += ' </tr> </thead> <tbody>';
        head = '<thead><tr>\
										<td>\
												Variable\
										</td>\
										<td class="d-none json">\
											json0\
										</td>\
									</tr>  </thead> <tbody>';
        if ($('#table-new').hasClass('dataTable')) {

            $('#table-new').DataTable().destroy();
        }

        $('.form-filter-date').each(function(index) {
            if ($(this).val() != '') {
                url_p1 += "YEAR(" + $(this).attr('name') + ")='" + $(this).val() + "' ";
            }

        });

        $('.js-example-basic-multiple').each(function(index) {

            if ($(this).val() != '' && $(this).attr('name') != 'FECHA') {

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

        const rutaUrl = document.getElementById('rutaUrl').getAttribute('data-value');
        new_url = rutaUrl + "/center/getCenterData/?kpi=" + kpi + "?where= " + url_p1;

        url =  rutaUrl;

        console.log(kpi);
        console.log(url_p1);

        if (cant == 0 || kpi == null) {
            document.getElementById('table-new').innerHTML =
                '<span class="badge badge-sm bg-gradient-danger mt-5 text-center card-title">Seleccione una empresa y/o Tipo</span>';
            return 0;
        }

        var request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject(
            'Microsoft.XMLHTTP');
        var ajaxUrl = url + '/center/getCenterData';
        var formData = new FormData();

        formData.append('kpi', kpi);
        formData.append("cwhere", url_p1);

        request.open("POST", ajaxUrl, true);
        request.send(formData);


        request.onreadystatechange = function() {
            if (request.readyState != 4) return;
            if (request.status == 200) {
                var objData = JSON.parse(request.responseText);
                var tbody = '';
                var thead = '';
                var data = objData.SQL_TABLA;


                document.getElementById('table-new').innerHTML = '';



                data.forEach(element => {

                    tbody += '<tr>\
									<td>\
										<div>\
											<div class="item-variables list-group-item-action variable bg-white p-2 rounded border border-secondary" style="cursor: pointer;">\
												' + element['VARIABLE'] + '\
											</div>\
										</div>\
									</td>';




                    if (cant !== 0 && cant !== 1) {


                        tbody += '<td class="d-none json-0">\
											' + JSON.stringify(element['JSON0']) + '\
										</td>';


                    } else {

                        tbody += '<td class="d-none json-' + 0 + '">\
											' + JSON.stringify(element) + '\
										</td>';
                    }



                    tbody += '</tr>';



                });
                document.getElementById('table-new').innerHTML = head + tbody + '</tbody>';
                //document.getElementById('body-table').innerHTML = tbody;



                $('#table-new').DataTable().destroy();

                $('#table-new').DataTable({     
                    "language": {
                        "lengthMenu": "",
                        "zeroRecords": "",
                        "info": "",
                        "infoEmpty": "",
                        "infoFiltered": "",
                        "search": "Buscar: ",
                        "paginate": {
                            "next": ">",
                            "previous": "<"

                        },
                    }

                });



            } else {
                return false;
            }

            return false;
        }


    });


    $("#table-new").on('click', 'tr', function(e) {
        e.preventDefault();


        if (cant !== 0 && cant !== 1) {
            var newDataLine = [];
            var newDataBar = [];
            var TotalBar = [];

            let datJson = JSON.parse($(this).find('.json-0').text());
            let dat = JSON.parse('[' + datJson + ']');



            dat.forEach(function(item, index) {
                let colorLine = '#' + ('000000' + Math.floor(Math.random() * 16777220).toString(
                    16)).slice(-6);
                let colorBar = '#' + ('000000' + Math.floor(Math.random() * 16777215).toString(
                    16)).slice(-6);
                let colorBartTotal = '#' + ('000000' + Math.floor(Math.random() * 16788215)
                    .toString(16)).slice(-6);

                newDataLine.push({
                    type: 'line',
                    label: item['EMPRESA'],
                    data: [item['ENE'], item['FEB'], item['MAR'], item['ABR'], item[
                        'MAY'], item['JUN'], item['JUL'], item['AGO'], item[
                        'SEP'], item['OCT'], item['NOV'], item['DIC']],
                    lineTension: 0.3,
                    borderColor: colorLine,
                    backgroundColor: colorLine
                });

                newDataBar.push({

                    label: item['EMPRESA'],
                    data: [item['ENEP'], item['FEBP'], item['MARP'], item['ABRP'], item[
                        'MAYP'], item['JUNP'], item['JULP'], item['AGOP'], item[
                        'SEPP'], item['OCTP'], item['NOVP'], item['DICP']],
                    borderColor: colorBar,
                    backgroundColor: colorBar
                });

                TotalBar.push({
                    label: item['EMPRESA'],
                    data: [item['TOTAL'], item['COMPARACION']],
                    borderColor: colorBartTotal,
                    backgroundColor: colorBartTotal
                });

            });



            lineChart2.data.datasets = newDataLine;
            lineChart2.update();

            barChart.data.datasets = newDataBar;
            barChart.update();

            TotalbarChart.data.datasets = TotalBar;
            TotalbarChart.update();


        } else {
            let data = JSON.parse($(this).find('.json-0').text());

            $('#valor1-1').text(aggDecimal(data['ENERO']).toString() + '%');
            $('#valor1-2').text(aggDecimal(data['ENEP']).toString() + '%');
            $('#valor1-3').text(0);
            $('#valor1-4').text(0);

            $('#valor2-1').text(aggDecimal(data['FEBRERO']).toString() + '%');
            $('#valor2-2').text(aggDecimal(data['FEBP']).toString() + '%');
            $('#valor1-3').text(aggDecimal(data['FEB_ENE']).toString() + '%');
            $('#valor1-4').text(aggDecimal(data['FEB_ENEP']).toString() + '%');

            $('#valor3-1').text(aggDecimal(data['MARZO']).toString() + '%');
            $('#valor3-2').text(aggDecimal(data['MARP']).toString() + '%');
            $('#valor2-3').text(aggDecimal(data['MAR_FEB']).toString() + '%');
            $('#valor2-4').text(aggDecimal(data['MAR_FEBP']).toString() + '%');


            $('#valor4-1').text(aggDecimal(data['ABRIL']).toString() + '%');
            $('#valor4-2').text(aggDecimal(data['ABRP']).toString() + '%');
            $('#valor3-3').text(aggDecimal(data['ABR_MAR']).toString() + '%');
            $('#valor3-4').text(aggDecimal(data['ABR_MARP']).toString() + '%');


            $('#valor5-1').text(aggDecimal(data['MAYO']).toString() + '%');
            $('#valor5-2').text(aggDecimal(data['MAYP']).toString() + '%');
            $('#valor4-3').text(aggDecimal(data['MAY_ABR']).toString() + '%');
            $('#valor4-4').text(aggDecimal(data['MAY_ABRP']).toString() + '%');


            $('#valor6-1').text(aggDecimal(data['JUNIO']));
            $('#valor6-2').text(aggDecimal(data['JUNP']).toString() + '%');
            $('#valor5-3').text(aggDecimal(data['JUN_MAY']).toString() + '%');
            $('#valor5-4').text(aggDecimal(data['JUN_MAYP']).toString() + '%');


            $('#valor7-1').text(aggDecimal(data['JULIO']).toString() + '%');
            $('#valor7-2').text(aggDecimal(data['JULP']).toString() + '%');
            $('#valor6-3').text(aggDecimal(data['JUL_JUN']).toString() + '%');
            $('#valor6-4').text(aggDecimal(data['JUL_JUNP']).toString() + '%');


            $('#valor8-1').text(aggDecimal(data['AGOSTO']).toString() + '%');
            $('#valor8-2').text(aggDecimal(data['AGOP']).toString() + '%');
            $('#valor7-3').text(aggDecimal(data['AGO_JUL']).toString() + '%');
            $('#valor7-4').text(aggDecimal(data['AGO_JULP']).toString() + '%');


            $('#valor9-1').text(aggDecimal(data['SEPTIEMBRE']).toString() + '%');
            $('#valor9-2').text(aggDecimal(data['SEPP']).toString() + '%');
            $('#valor8-3').text(aggDecimal(data['SEP_AGO']).toString() + '%');
            $('#valor8-4').text(aggDecimal(data['SEP_AGOP']).toString() + '%');


            $('#valor10-1').text(aggDecimal(data['OCTUBRE']).toString() + '%');
            $('#valor10-2').text(aggDecimal(data['OCTP']).toString() + '%');
            $('#valor9-3').text(aggDecimal(data['OCT_SEP']).toString() + '%');
            $('#valor9-4').text(aggDecimal(data['OCT_SEPP']).toString() + '%');


            $('#valor11-1').text(aggDecimal(data['NOVIEMBRE']).toString() + '%');
            $('#valor11-2').text(aggDecimal(data['NOVP']).toString() + '%');
            $('#valor10-3').text(aggDecimal(data['NOV_OCT']).toString() + '%');
            $('#valor10-4').text(aggDecimal(data['NOV_OCTP']).toString() + '%');


            $('#valor12-1').text(aggDecimal(data['DICIEMBRE']).toString() + '%');
            $('#valor12-2').text(aggDecimal(data['DICP']).toString() + '%');
            $('#valor11-3').text(aggDecimal(data['DIC_NOV']).toString() + '%');
            $('#valor11-4').text(aggDecimal(data['DIC_NOVP']).toString() + '%');


            $('#valor-total').text(aggDecimal(data['TOTAL']).toString() + '%');
            $('#valor-totalp').text(aggDecimal(data['TOTP']).toString() + '%');
            $('#valor-comparacion').text(aggDecimal(data['COMPARACION']).toString() + '%');
            $('#valor-comparacionp').text(aggDecimal(data['COMPP']).toString() + '%');



            var newData = {

                labels: ["enero", "Febrero", "Marzo", "Abril", "Mayo", 'Junio', 'Julio', 'Agosto',
                    'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'
                ],
                datasets: [{
                        type: 'line',
                        label: 'Meses',
                        data: [data['ENERO'], data['FEBRERO'], data['MARZO'], data['ABRIL'],
                            data['MAYO'], data['JUNIO'], data['JULIO'], data['AGOSTO'],
                            data['SEPTIEMBRE'], data['OCTUBRE'], data['NOVIEMBRE'], data[
                                'DICIEMBRE']
                        ],
                        lineTension: 0.3,
                        borderColor: 'rgba(255, 99, 132, 1)',
                        backgroundColor: 'rgba(255, 99, 132, 0.2)'
                    },
                    {
                        type: 'bar',
                        label: "Comparativa",
                        data: [0, data['FEB_ENE'], data['MAR_FEB'], data['ABR_MAR'], data[
                            'MAY_ABR'], data['JUN_MAY'], data['JUL_JUN'], data[
                            'AGO_JUL'], data['SEP_AGO'], data['OCT_SEP'], data[
                            'NOV_OCT'], data['DIC_NOV']],
                        lineTension: 0.3,
                        borderColor: 'rgba(75, 192, 192, 1)',
                        backgroundColor: 'rgba(75, 192, 192, 0.2)',
                    }
                ]
            };

            lineChart.data.datasets = newData.datasets;
            lineChart.update();
        }
    });




    function aggDecimal(data) {

        let d1 = parseFloat(data);
        let d4 = 0;

        d4 = d1.toLocaleString('en-US', {
            minimumFractionDigits: 2,
            maximumFractionDigits: 2
        });


        return d4;
    };

}, false);