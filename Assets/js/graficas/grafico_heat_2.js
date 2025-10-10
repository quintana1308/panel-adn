const ElementPricipalHeat2 = document.getElementById('graficaPricipalHeat2');

if (ElementPricipalHeat2 && ElementPricipalHeat2.getAttribute('data-value')) {
    try {
        const graficaPricipalHeat2 = JSON.parse(ElementPricipalHeat2.getAttribute('data-value'));

        // Verificar el campo status antes de ejecutar el gráfico
        if (graficaPricipalHeat2.statusGrafic === 1) {

            let idGrafic = document.getElementById('graficaPricipalHeat2_id');
            idGrafic.innerHTML  = "<p class='text-center'>La Gráfica no esta disponible</p>"; 

        }else{
            function getPointCategoryName(point, dimension) {
                const series = point.series,
                    isY = dimension === 'y',
                    axis = series[isY ? 'yAxis' : 'xAxis'];
                return axis.categories[point[isY ? 'y' : 'x']];
            }

            // Extraer categorías X e Y
            const xCategories2 = graficaPricipalHeat2.PARAM3.map(item => item.MES); // Extraer categorías X
            const yCategories2 = graficaPricipalHeat2.PARAM4.map(item => item.SCS); // Extraer categorías Y

            // Transformar los datos para el gráfico
            const data2 = [];
            graficaPricipalHeat2.PARAM5.forEach((item, index) => {
                // Aquí asumimos que los datos están organizados en un formato específico.
                // La posición en X es la posición en el array
                // La posición en Y se calcula según el número de categorías Y disponibles
                const x = index % xCategories2.length;
                const y = Math.floor(index / xCategories2.length);
                if (y < yCategories2.length) { // Verifica que el índice Y esté dentro de los límites
                    data2.push([x, y, parseFloat(item.MES1)]);
                }
            });

            Highcharts.chart('graficaPricipalHeat2_id', {
                chart: {
                    type: 'heatmap',
                    marginTop: 40,
                    marginBottom: 80,
                    plotBorderWidth: 1
                },
                
                title: {
                    text: graficaPricipalHeat2.DESCRIPTION
                },
                
                xAxis: {
                    categories: xCategories2
                },
                
                yAxis: {
                    categories: yCategories2,
                    title: null,
                    reversed: true
                },
                
                accessibility: {
                    point: {
                        descriptionFormatter: function(point) {
                            const ix = point.index + 1,
                                xName = getPointCategoryName(point, 'x'),
                                yName = getPointCategoryName(point, 'y'),
                                val = point.value;
                            return ix + '. ' + xName + ' sales ' + yName + ', ' + val + '.';
                        }
                    }
                },
                
                colorAxis: {
                    min: 0,
                    minColor: '#FFFFFF',
                    maxColor: Highcharts.getOptions().colors[0]
                },
                
                legend: {
                    align: 'right',
                    layout: 'vertical',
                    margin: 0,
                    verticalAlign: 'top',
                    y: 25,
                    symbolHeight: 280
                },
                
                tooltip: {
                    formatter: function() {
                        return '<b>' + getPointCategoryName(this.point, 'x') + '</b> mes <br><b>' +
                            this.point.value + '</b> gasto en  <br><b>' + getPointCategoryName(this.point, 'y') +
                            '</b>';
                    }
                },
                
                series: [{
                    name: 'Sales per employee',
                    borderWidth: 1,
                    data: data2,
                    dataLabels: {
                        enabled: true,
                        color: '#000000'
                    }
                }],
                
                responsive: {
                    rules: [{
                        condition: {
                            maxWidth: 500
                        },
                        chartOptions: {
                            yAxis: {
                                labels: {
                                    formatter: function() {
                                        return this.value.charAt(0);
                                    }
                                }
                            }
                        }
                    }]
                }
            });
        }
    } catch (error) {
        console.error(`Error al generar el gráfico Heat2: ${error.message}`);
    }
}