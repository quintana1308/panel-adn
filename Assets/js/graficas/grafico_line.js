const ElementPricipalLine = document.getElementById('graficaPricipalLine');

if (ElementPricipalLine && ElementPricipalLine.getAttribute('data-value')) {
    try {
        const graficaPricipalLine = JSON.parse(ElementPricipalLine.getAttribute('data-value'));

        // Verificar el campo status antes de ejecutar el gráfico
        if (graficaPricipalLine.statusGrafic === 1) {

            let idGrafic = document.getElementById('graficaPricipalLine_id');
            idGrafic.innerHTML  = "<p class='text-center'>La Gráfica no esta disponible</p>"; 

        }else{
            const seriesDataLine = [];
            for (let i = 0; i < graficaPricipalLine.PARAM4.length; i++) {
                seriesDataLine.push({
                    name: graficaPricipalLine.PARAM4[i].SCS,
                    data: graficaPricipalLine.PARAM5.map(obj => Number(obj.MES1))
                });
            }

            Highcharts.chart('graficaPricipalLine_id', {
                chart: {
                    type: 'line'
                },
                title: {
                    text: graficaPricipalLine.DESCRIPTION
                },
                subtitle: {
                    text: graficaPricipalLine.PARAM2
                },
                xAxis: {
                    categories: graficaPricipalLine.PARAM3.map(obj => Number(obj.MES))
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
                series: seriesDataLine
            });
        }
    } catch (error) {
        console.error(`Error al generar el gráfico Line: ${error.message}`);
    }
}