const ElementResumenPie2 = document.getElementById('graficaResumenPie2');

if (ElementResumenPie2 && ElementResumenPie2.getAttribute('data-value')) {

    const graficaResumenPie2 = JSON.parse(ElementResumenPie2.getAttribute('data-value'));

    // Configurar el gráfico de pie con Highcharts
    Highcharts.chart('graficaResumenPie2_id', {
        chart: {
            plotBackgroundColor: null,
            plotBorderWidth: null,
            plotShadow: false,
            type: 'pie'
        },
        title: {
            text: graficaResumenPie2.DESCRIPTION
        },
        subtitle: {
            text: graficaResumenPie2.PARAM2
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
            data: graficaResumenPie2.PARAM3.map((item, index) => {
                const name = Object.values(item)[0];
                const value = parseFloat(Object.values(graficaResumenPie2.PARAM4[index])[0]);
                return {
                    name: name,
                    y: value
                };
            })
        }]
    });

}