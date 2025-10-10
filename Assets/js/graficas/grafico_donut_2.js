const ElementPricipalDonut2 = document.getElementById('graficaPricipalDonut2');

if (ElementPricipalDonut2 && ElementPricipalDonut2.getAttribute('data-value')) {
    try {
        const graficaPricipalDonut2 = JSON.parse(ElementPricipalDonut2.getAttribute('data-value'));

        // Verificar el campo status antes de ejecutar el gráfico
        if (graficaPricipalDonut2.statusGrafic === 1) {

            let idGrafic = document.getElementById('graficaPricipalDonut2_id');
            idGrafic.innerHTML  = "<p class='text-center'>La Gráfica no esta disponible</p>"; 

        }else{
            Highcharts.chart('graficaPricipalDonut2_id', {
                chart: {
                    type: 'pie',
                    options3d: {
                        enabled: true,
                        alpha: 45
                    }
                },
                title: {
                    text: graficaPricipalDonut2.DESCRIPTION
                },
                subtitle: {
                    text: graficaPricipalDonut2.PARAM2
                },
                plotOptions: {
                    pie: {
                        innerSize: 100,
                        depth: 45
                    }
                },
                series: [{
                    name: '',
                    data: graficaPricipalDonut2.PARAM3.map((item, index) => {
                        const name = Object.values(item)[0];
                        const value = parseFloat(Object.values(graficaPricipalDonut2.PARAM4[index])[0]);
                        return {
                            name: name,
                            y: value
                        };
                    })
                }]
            });
        }
    } catch (error) {
        console.error(`Error al generar el gráfico Donut: ${error.message}`);
    }
}