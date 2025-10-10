const ElementPricipalPie = document.getElementById('graficaPricipalPie');

if (ElementPricipalPie && ElementPricipalPie.getAttribute('data-value')) {
    try {
        const graficaPricipalPie = JSON.parse(ElementPricipalPie.getAttribute('data-value'));
        const idgrafPie = document.getElementById('graficaPricipalPie').getAttribute('data-id');

        // Verificar el campo status antes de ejecutar el gráfico
        if (graficaPricipalPie.statusGrafic === 1) {

            let idGrafic = document.getElementById('graficaPricipalPie_id');
            idGrafic.innerHTML  = "<p class='text-center'>La Gráfica no esta disponible</p>"; 

        }else{
            // Configurar el gráfico de pie con Highcharts
            Highcharts.chart('graficaPricipalPie_id', {
                chart: {
                    plotBackgroundColor: null,
                    plotBorderWidth: null,
                    plotShadow: false,
                    type: 'pie' 
                },
                title: {
                    text: graficaPricipalPie.DESCRIPTION
                },
                subtitle: {
                    text: graficaPricipalPie.PARAM2
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
                    data: graficaPricipalPie.PARAM3.map((item, index) => {
                        const name = Object.values(item)[0];
                        const value = parseFloat(Object.values(graficaPricipalPie.PARAM4[index])[0]);
                        return {
                            name: name,
                            y: value
                        };
                    })
                }]
            });

        }

    } catch (error) {
        console.error(`Error al generar el gráfico Pie: ${error.message}`);
    }
}