const ElementResumenPie = document.getElementById('graficaResumenPie');

if (ElementResumenPie && ElementResumenPie.getAttribute('data-value')) {

    const graficaResumenPie = JSON.parse(ElementResumenPie.getAttribute('data-value'));

    // Configurar el gráfico de pie con Highcharts
    Highcharts.chart('graficaResumenPie_id', {
        chart: {
            plotBackgroundColor: null,
            plotBorderWidth: null,
            plotShadow: false,
            type: 'pie'
        },
        title: {
            text: graficaResumenPie.DESCRIPTION
        },
        subtitle: {
            text: graficaResumenPie.PARAM2
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
            data: graficaResumenPie.PARAM3.map((item, index) => {
                const name = Object.values(item)[0];
                const value = parseFloat(Object.values(graficaResumenPie.PARAM4[index])[0]);
                return {
                    name: name,
                    y: value
                };
            })
        }]
    });

}