const ElementResumenLine2 = document.getElementById('graficaResumenLine2');

if (ElementResumenLine2 && ElementResumenLine2.getAttribute('data-value')) {

    const graficaResumenLine2 = JSON.parse(ElementResumenLine2.getAttribute('data-value'));

    const seriesDataLineResumen2 = [];
    for (let i = 0; i < graficaResumenLine2.PARAM4.length; i++) {
        seriesDataLineResumen2.push({
            name: graficaResumenLine2.PARAM4[i].SCS,
            data: graficaResumenLine2.PARAM5.map(obj => Number(obj.MES1))
        });
    }

    Highcharts.chart('graficaResumenLine2_id', {
        chart: {
            type: 'line'
        },
        title: {
            text: graficaResumenLine2.DESCRIPTION
        },
        subtitle: {
            text: graficaResumenLine2.PARAM2
        },
        xAxis: {
            categories: graficaResumenLine2.PARAM3.map(obj => Number(obj.MES))
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
        series: seriesDataLineResumen2
    });

}