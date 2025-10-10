const ElementResumenColumn2 = document.getElementById('graficaResumenColumn2');

if (ElementResumenColumn2 && ElementResumenColumn2.getAttribute('data-value')) {

    const graficaResumenColumn2 = JSON.parse(ElementResumenColumn2.getAttribute('data-value'));

    // Adaptamos el ciclo PHP a JavaScript para generar las series de datos
    const seriesDataColumnResumen2 = [];

    graficaResumenColumn2.PARAM4.forEach((serie, index) => {
        seriesDataColumnResumen2.push({
            name: serie.SCS,  // Nombre de la serie (dinámico)
            data: graficaResumenColumn2.PARAM5.map(obj => Number(obj[serie.SCS]))  // Datos correspondientes a cada serie
        });
    });

    const categoriesArrayResumen2 = graficaResumenColumn2.PARAM3.map(obj => obj.MES.toString().trim().replace(/'/g, ''));


    Highcharts.chart('graficaResumenColumn2_id', {
        chart: {
            type: 'column'
        },
        title: {
            text: graficaResumenColumn2.DESCRIPTION
        },
        subtitle: {
            text: graficaResumenColumn2.PARAM2
        },
        xAxis: {
            categories: categoriesArrayResumen2,
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
        series: seriesDataColumnResumen2
    });

}