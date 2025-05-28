export function cardConversations() {
    // Datos de ventas
    var ventasDiarias = [
        3150000, 2980000, 2750000, 6320000, 7240000, 3180000, 2890000,
        3050000, 2780000, 3320000, 6580000, 7120000, 2950000, 3080000,
        4250000, 3620000, 3490000, 6920000, 7580000, 3270000, 3180000,
        2950000, 3420000, 3740000, 7180000, 7850000, 3190000, 3050000,
        3270000, 3860000, 4120000
    ];
    // Calcular el total de ventas
    var totalVentas = ventasDiarias.reduce((a, b) => a + b, 0);

    // Formatear el total como pesos colombianos
    var totalFormateado = '$ ' + totalVentas.toLocaleString('es-CO');

    var spark1 = {
        series: [{
            name: 'Conversaciones',
            data: [44, 55, 41, 67, 22, 43, 21, 33, 45]
        }],
        annotations: {
        },
        chart: {
            height: 200,
            type: 'bar',
        },
        plotOptions: {
            bar: {
                borderRadius: 10,
                columnWidth: '50%',
            }
        },
        dataLabels: {
            enabled: false
        },
        stroke: {
            width: 0
        },
        grid: {
            row: {
                colors: ['#fff', '#f2f2f2']
            }
        },
        xaxis: {
            labels: {
                rotate: -45
            },
            categories: ['Bulevar', 'Ecoplaza', 'Neiva', 'Bello', 'Hayuelos', 'Altavista',
                'Paseo', 'Cali', 'Mayorca'
            ],
            tickPlacement: 'on'
        },
        yaxis: {
            title: {
                text: 'Conversaciones',
            },
        },
        fill: {
            type: 'gradient',
            gradient: {
                shade: 'light',
                type: "vertical",
                shadeIntensity: 0.4,
                gradientToColors: ['#B31F28'], // blueStar
                inverseColors: false,
                opacityFrom: 0.8,
                stops: [0, 100]
            },
            colors: ['#0078B6']
        }
    };

    new ApexCharts(document.querySelector("#spark1"), spark1).render();
}