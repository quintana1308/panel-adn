const ElementResumenColumn = document.getElementById('graficaResumenColumn');

if (ElementResumenColumn && ElementResumenColumn.getAttribute('data-value')) {

    const graficaResumenColumn = JSON.parse(ElementResumenColumn.getAttribute('data-value'));

    // Adaptamos el ciclo PHP a JavaScript para generar las series de datos
    const seriesDataColumnResumen = [];

    // Iterar sobre PARAM4 para obtener los nombres de las series (dinámicamente)
    graficaResumenColumn.PARAM4.forEach((serie, index) => {
        seriesDataColumnResumen.push({
            name: serie.SCS,  // Nombre de la serie (dinámico)
            data: graficaResumenColumn.PARAM5.map(obj => Number(obj[serie.SCS]))  // Datos correspondientes a cada serie
        });
    });

    const categoriesArrayResumen = graficaResumenColumn.PARAM3.map(obj => obj.MES.toString().trim().replace(/'/g, ''));


    Highcharts.chart('graficaResumenColumn_id', {
        chart: {
            type: 'column'
        },
        title: {
            text: graficaResumenColumn.DESCRIPTION
        },
        subtitle: {
            text: graficaResumenColumn.PARAM2
        },
        xAxis: {
            categories: categoriesArrayResumen,
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
        series: seriesDataColumnResumen
    });

}