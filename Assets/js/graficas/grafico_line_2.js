const ElementPricipalLine2 = document.getElementById('graficaPricipalLine2');

if (ElementPricipalLine2 && ElementPricipalLine2.getAttribute('data-value')) {
    try {
        const graficaPricipalLine2 = JSON.parse(ElementPricipalLine2.getAttribute('data-value'));

        // Verificar el campo status antes de ejecutar el gráfico
        if (graficaPricipalLine2.statusGrafic === 1) {

            let idGrafic = document.getElementById('graficaPricipalLine2_id');
            idGrafic.innerHTML  = "<p class='text-center'>La Gráfica no esta disponible</p>"; 

        }else{
            const seriesDataLine2 = [];
            for (let i = 0; i < graficaPricipalLine2.PARAM4.length; i++) {
                seriesDataLine2.push({
                    name: graficaPricipalLine2.PARAM4[i].SCS,
                    data: graficaPricipalLine2.PARAM5.map(obj => Number(obj.MES1))
                });
            }

            Highcharts.chart('graficaPricipalLine2_id', {
                chart: {
                    type: 'line'
                },
                title: {
                    text: graficaPricipalLine2.DESCRIPTION
                },
                subtitle: {
                    text: graficaPricipalLine2.PARAM2
                },
                xAxis: {
                    categories: graficaPricipalLine2.PARAM3.map(obj => Number(obj.MES))
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
                series: seriesDataLine2
            });
        }
    } catch (error) {
        console.error(`Error al generar el gráfico Line2: ${error.message}`);
    }
}