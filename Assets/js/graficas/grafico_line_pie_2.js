const ElementPricipalLinePie2 = document.getElementById('graficaPricipalLinePie2');

if (ElementPricipalLinePie2 && ElementPricipalLinePie2.getAttribute('data-value')) {
    try {
        const graficaPricipalLinePie2 = JSON.parse(ElementPricipalLinePie2.getAttribute('data-value'));

        // Verificar el campo status antes de ejecutar el gráfico
        if (graficaPricipalLinePie2.statusGrafic === 1) {

            let idGrafic = document.getElementById('graficaPricipalLinePie2_id');
            idGrafic.innerHTML  = "<p class='text-center'>La Gráfica no esta disponible</p>"; 

        }else{
            Highcharts.chart('graficaPricipalLinePie2_id', {
                title: {
                    text: graficaPricipalLinePie2.PARAM1,
                    align: 'left'
                },
                xAxis: {
                    categories: graficaPricipalLinePie2.PARAM3.map(item => Object.values(item)[0]) // Extrae los nombres de los meses
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
                    ...graficaPricipalLinePie2.PARAM5[0] && Object.keys(graficaPricipalLinePie2.PARAM5[0]).map((key, index) => ({
                        type: 'column',
                        name: graficaPricipalLinePie2.PARAM4[index] ? Object.values(graficaPricipalLinePie2.PARAM4[index])[0] : `Serie ${index + 1}`,
                        data: graficaPricipalLinePie2.PARAM5.map(monthData => monthData[key])
                    })),
                    
                    // Data for spline
                    {
                        type: 'spline',
                        name: 'PROMEDIO',
                        data: graficaPricipalLinePie2.PARAM6 ? graficaPricipalLinePie2.PARAM6.split(',').map(Number) : [], // Asegúrate de tener PARAM6 en el JSON
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
                        data: graficaPricipalLinePie2.PARAM7 ? graficaPricipalLinePie2.PARAM7.map((item, index) => ({
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
        console.error(`Error al generar el gráfico LinePie2: ${error.message}`);
    }
}