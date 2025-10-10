const ElementResumenLine = document.getElementById('graficaResumenLine');

if (ElementResumenLine && ElementResumenLine.getAttribute('data-value')) {

    const graficaResumenLine = JSON.parse(ElementResumenLine.getAttribute('data-value'));

    const seriesDataLineResumen = [];
    for (let i = 0; i < graficaResumenLine.PARAM4.length; i++) {
        seriesDataLineResumen.push({
            name: graficaResumenLine.PARAM4[i].SCS,
            data: graficaResumenLine.PARAM5.map(obj => Number(obj.MES1))
        });
    }


    Highcharts.chart('graficaResumenLine_id', {
        chart: {
            type: 'line'
        },
        title: {
            text: graficaResumenLine.DESCRIPTION
        },
        subtitle: {
            text: graficaResumenLine.PARAM2
        },
        xAxis: {
            categories: graficaResumenLine.PARAM3.map(obj => Number(obj.MES))
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
        series: seriesDataLineResumen
    });

}