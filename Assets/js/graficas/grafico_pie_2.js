const ElementPricipalPie2 = document.getElementById('graficaPricipalPie2');

if (ElementPricipalPie2 && ElementPricipalPie2.getAttribute('data-value')) {
    try {
        const graficaPricipalPie2 = JSON.parse(ElementPricipalPie2.getAttribute('data-value'));

        // Verificar el campo status antes de ejecutar el gráfico
        if (graficaPricipalPie2.statusGrafic === 1) {

            let idGrafic = document.getElementById('graficaPricipalPie2_id');
            idGrafic.innerHTML  = "<p class='text-center'>La Gráfica no esta disponible</p>"; 

        }else{
            // Configurar el gráfico de pie con Highcharts
            Highcharts.chart('graficaPricipalPie2_id', {
                chart: {
                    plotBackgroundColor: null,
                    plotBorderWidth: null,
                    plotShadow: false,
                    type: 'pie'
                },
                title: {
                    text: graficaPricipalPie2.DESCRIPTION
                },
                subtitle: {
                    text: graficaPricipalPie2.PARAM2
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
                    data: graficaPricipalPie2.PARAM3.map((item, index) => {
                        const name = Object.values(item)[0];
                        const value = parseFloat(Object.values(graficaPricipalPie2.PARAM4[index])[0]);
                        return {
                            name: name,
                            y: value
                        };
                    })
                }]
            });
        }
    } catch (error) {
        console.error(`Error al generar el gráfico Pie2: ${error.message}`);
    }
}   