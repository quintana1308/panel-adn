const ElementResumenDonut = document.getElementById('graficaResumenDonut');

if (ElementResumenDonut && ElementResumenDonut.getAttribute('data-value')) {

    const graficaResumenDonut = JSON.parse(ElementResumenDonut.getAttribute('data-value'));

    Highcharts.chart('graficaResumenDonut_id', {
        chart: {
            type: 'pie',
            options3d: {
                enabled: true,
                alpha: 45
            }
        },
        title: {
            text: graficaResumenDonut.DESCRIPTION
        },
        subtitle: {
            text: graficaResumenDonut.PARAM2
        },
        plotOptions: {
            pie: {
                innerSize: 100,
                depth: 45
            }
        },
        series: [{
            name: '',
            data: graficaResumenDonut.PARAM3.map((item, index) => {
                const name = Object.values(item)[0];
                const value = parseFloat(Object.values(graficaResumenDonut.PARAM4[index])[0]);
                return {
                    name: name,
                    y: value
                };
            })
        }]
    });


}