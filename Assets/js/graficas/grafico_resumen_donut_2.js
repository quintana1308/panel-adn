const ElementResumenDonut2 = document.getElementById('graficaResumenDonut2');

if (ElementResumenDonut2 && ElementResumenDonut2.getAttribute('data-value')) {

    const graficaResumenDonut2 = JSON.parse(ElementResumenDonut2.getAttribute('data-value'));

    Highcharts.chart('graficaResumenDonut2_id', {
        chart: {
            type: 'pie',
            options3d: {
                enabled: true,
                alpha: 45
            }
        },
        title: {
            text: graficaResumenDonut2.DESCRIPTION
        },
        subtitle: {
            text: graficaResumenDonut2.PARAM2
        },
        plotOptions: {
            pie: {
                innerSize: 100,
                depth: 45
            }
        },
        series: [{
            name: '',
            data: graficaResumenDonut2.PARAM3.map((item, index) => {
                const name = Object.values(item)[0];
                const value = parseFloat(Object.values(graficaResumenDonut2.PARAM4[index])[0]);
                return {
                    name: name,
                    y: value
                };
            })
        }]
    });

}