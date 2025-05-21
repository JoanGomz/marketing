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

    var spark2 = {
        chart: {
            id: 'sparkline1',
            group: 'sparklines',
            type: 'area',
            height: 160,
            sparkline: {
                enabled: true
            },
        },
        stroke: {
            curve: 'straight'
        },
        fill: {
            opacity: 1,
        },
        series: [{
            name: 'Total ventas',
            data: ventasDiarias
        }],
        labels: [
            "1 Mayo", "2 Mayo", "3 Mayo", "4 Mayo", "5 Mayo", "6 Mayo", "7 Mayo",
            "8 Mayo", "9 Mayo", "10 Mayo", "11 Mayo", "12 Mayo", "13 Mayo", "14 Mayo",
            "15 Mayo", "16 Mayo", "17 Mayo", "18 Mayo", "19 Mayo", "20 Mayo", "21 Mayo",
            "22 Mayo", "23 Mayo", "24 Mayo", "25 Mayo", "26 Mayo", "27 Mayo", "28 Mayo",
            "29 Mayo", "30 Mayo", "31 Mayo"
        ],
        tooltip: {
            fixed: {
                enabled: false
            },
            x: {
                show: true
            },
            y: {
                title: {
                    formatter: function (seriesName) {
                        return 'Ventas del día:';
                    }
                },
                formatter: function (value) {
                    return '$ ' + value.toLocaleString('es-CO') + ' COP';
                }
            },
            marker: {
                show: false
            }
        },
        yaxis: {
            min: 0,
            labels: {
                formatter: function (value) {
                    if (value >= 1000000) {
                        return '$ ' + (value / 1000000).toFixed(1) + 'M';
                    } else if (value >= 1000) {
                        return '$ ' + (value / 1000).toFixed(0) + 'K';
                    }
                    return '$ ' + value;
                }
            }
        },
        xaxis: {
            type: 'datetime',
        },
        colors: ['#0078B6'],
        title: {
            text: totalFormateado,
            offsetX: 30,
            style: {
                fontSize: '24px',
                cssClass: 'apexcharts-yaxis-title'
            }
        },
        subtitle: {
            text: 'Ventas Totales Mayo / Ecoplaza',
            offsetX: 30,
            style: {
                fontSize: '14px',
                cssClass: 'apexcharts-yaxis-title'
            }
        }
    };

    new ApexCharts(document.querySelector("#spark2"), spark2).render();
}