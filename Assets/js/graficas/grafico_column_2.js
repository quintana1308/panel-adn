const ElementPrincipalColumn2 = document.getElementById('graficaPricipalColumn2');

if (ElementPrincipalColumn2 && ElementPrincipalColumn2.getAttribute('data-value')) {
    try {
        const graficaPricipalColumn2 = JSON.parse(ElementPrincipalColumn2.getAttribute('data-value'));

        // Verificar el campo status antes de ejecutar el gráfico
        if (graficaPricipalColumn2.statusGrafic === 1) {

            let idGrafic = document.getElementById('graficaPricipalColumn2_id');
            idGrafic.innerHTML  = "<p class='text-center'>La Gráfica no esta disponible</p>"; 

        }else{
            // Adaptamos el ciclo PHP a JavaScript para generar las series de datos
            const seriesDataColumn2 = [];
            
            for (let i = 0; i < graficaPricipalColumn2.PARAM4.length; i++) {
                seriesDataColumn2.push({
                    name: graficaPricipalColumn2.PARAM4[i].SCS,  // Nombre de la serie
                    data: graficaPricipalColumn2.PARAM5.map(obj => Number(obj.MES1))
                });
            }
            const categoriesArray2 = graficaPricipalColumn2.PARAM3.map(obj => obj.MES.toString().trim().replace(/'/g, ''));
            
            
            Highcharts.chart('graficaPricipalColumn2_id', {
                chart: {
                    type: 'column'
                },
                title: {
                    text: graficaPricipalColumn2.DESCRIPTION
                },
                subtitle: {
                    text: graficaPricipalColumn2.PARAM2
                },
                xAxis: {
                    categories: categoriesArray2,
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
                series: seriesDataColumn2
            });
        }
    } catch (error) {
        console.error(`Error al generar el gráfico Column2: ${error.message}`);
    }
}