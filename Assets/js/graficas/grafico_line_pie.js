const ElementPricipalLinePie = document.getElementById('graficaPricipalLinePie');

if (ElementPricipalLinePie && ElementPricipalLinePie.getAttribute('data-value')) {
    try {
        const graficaPricipalLinePie = JSON.parse(ElementPricipalLinePie.getAttribute('data-value'));

        // Verificar el campo status antes de ejecutar el gráfico
        if (graficaPricipalLinePie.statusGrafic === 1) {

            let idGrafic = document.getElementById('graficaPricipalLinePie_id');
            idGrafic.innerHTML  = "<p class='text-center'>La Gráfica no esta disponible</p>"; 

        }else{

            Highcharts.chart('graficaPricipalLinePie_id', {
                title: {
                    text: graficaPricipalLinePie.PARAM1,
                    align: 'left'
                },
                xAxis: {
                    categories: graficaPricipalLinePie.PARAM3.map(item => Object.values(item)[0]) // Extrae los nombres de los meses
                },
                yAxis: {
                    title: {
                        text: ''
                    }
                },
                tooltip: {
                    valueSuffix: ' '
                },
                plotOptions: {
                    series: {
                        borderRadius: '25%'
                    }
                },
                series: [
                    // Data for columns
                    ...graficaPricipalLinePie.PARAM5[0] && Object.keys(graficaPricipalLinePie.PARAM5[0]).map((key, index) => ({
                        type: 'column',
                        name: graficaPricipalLinePie.PARAM4[index] ? Object.values(graficaPricipalLinePie.PARAM4[index])[0] : `Serie ${index + 1}`,
                        data: graficaPricipalLinePie.PARAM5.map(monthData => monthData[key])
                    })),
                    
                    // Data for spline
                    {
                        type: 'spline',
                        name: 'PROMEDIO',
                        data: graficaPricipalLinePie.PARAM6 ? graficaPricipalLinePie.PARAM6.split(',').map(Number) : [], // Asegúrate de tener PARAM6 en el JSON
                        marker: {
                            lineWidth: 2,
                            lineColor: Highcharts.getOptions().colors[3],
                            fillColor: 'white'
                        }
                    },
                    
                    // Data for pie
                    {
                        type: 'pie',
                        name: 'Total',
                        data: graficaPricipalLinePie.PARAM7 ? graficaPricipalLinePie.PARAM7.map((item, index) => ({
                            name: item[0],
                            y: item[1],
                            color: Highcharts.getOptions().colors[index]
                        })) : [], // Asegúrate de tener PARAM7 en el JSON
                        center: [45, 35],
                        size: 100,
                        innerSize: '70%',
                        showInLegend: false,
                        dataLabels: {
                            enabled: false
                        }
                    }
                ]
            });
        }
    } catch (error) {
        console.error(`Error al generar el gráfico LinePie: ${error.message}`);
    }
}