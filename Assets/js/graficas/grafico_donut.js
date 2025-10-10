const ElementPricipalDonut = document.getElementById('graficaPricipalDonut');

if (ElementPricipalDonut && ElementPricipalDonut.getAttribute('data-value')) {
    try {
        const graficaPricipalDonut = JSON.parse(ElementPricipalDonut.getAttribute('data-value'));
        const idgrafDonut = document.getElementById('graficaPricipalDonut').getAttribute('data-id');

        // Verificar el campo status antes de ejecutar el gráfico
        if (graficaPricipalDonut.statusGrafic === 1) {

            let idGrafic = document.getElementById('graficaPricipalDonut_id');
            idGrafic.innerHTML  = "<p class='text-center'>La Gráfica no esta disponible</p>"; 

        }else{
            Highcharts.chart('graficaPricipalDonut_id', {
                chart: {
                    type: 'pie',
                    options3d: {
                        enabled: true,
                        alpha: 45
                    }
                },
                title: {
                    text: graficaPricipalDonut.DESCRIPTION
                },
                subtitle: {
                    text: graficaPricipalDonut.PARAM2
                },
                plotOptions: {
                    pie: {
                        innerSize: 100,
                        depth: 45
                    }
                },
                series: [{
                    name: '',
                    data: graficaPricipalDonut.PARAM3.map((item, index) => {
                        const name = Object.values(item)[0];
                        const value = parseFloat(Object.values(graficaPricipalDonut.PARAM4[index])[0]);
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