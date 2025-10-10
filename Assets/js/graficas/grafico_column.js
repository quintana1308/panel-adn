const ElementPrincipalColumn = document.getElementById('graficaPricipalColumn');

if (ElementPrincipalColumn && ElementPrincipalColumn.getAttribute('data-value')) {
    try {
        const graficaPricipalColumn = JSON.parse(ElementPrincipalColumn.getAttribute('data-value'));

        // Verificar el campo status antes de ejecutar el gráfico
        if (graficaPricipalColumn.statusGrafic === 1) {

            let idGrafic = document.getElementById('graficaPricipalColumn_id');
            idGrafic.innerHTML  = "<p class='text-center'>La Gráfica no esta disponible</p>"; 

        }else{
            // Adaptamos el ciclo PHP a JavaScript para generar las series de datos
            const seriesDataColumn = [];

            for (let i = 0; i < graficaPricipalColumn.PARAM4.length; i++) {
                seriesDataColumn.push({
                    name: graficaPricipalColumn.PARAM4[i].SCS,  // Nombre de la serie
                    data: graficaPricipalColumn.PARAM5.map(obj => Number(obj.MES1))
                });
            }
            const categoriesArray = graficaPricipalColumn.PARAM3.map(obj => obj.MES.toString().trim().replace(/'/g, ''));


            Highcharts.chart('graficaPricipalColumn_id', {
                chart: {
                    type: 'column'
                },
                title: {
                    text: graficaPricipalColumn.DESCRIPTION
                },
                subtitle: {
                    text: graficaPricipalColumn.PARAM2
                },
                xAxis: {
                    categories: categoriesArray,
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
                series: seriesDataColumn
            });
        }
    } catch (error) {
        console.error(`Error al generar el gráfico Column: ${error.message}`);
    }
}