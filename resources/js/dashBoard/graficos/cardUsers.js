export function cardUsers() {
    // Datos de ventas
    var ventasDiarias = [
        2350000, 2180000, 2420000, 15760000, 6120000, 2640000, 2180000,
        2380000, 2520000, 2680000, 5920000, 6240000, 2420000, 2360000,
        2540000, 2680000, 2780000, 5840000, 6320000, 2460000, 2520000,
        2380000, 2620000, 2840000, 5980000, 6480000, 2240000, 2320000,
        2460000, 2580000, 2740000
    ];

    // Calcular el total de ventas
    var totalVentas = ventasDiarias.reduce((a, b) => a + b, 0);

    // Formatear el total como pesos colombianos
    var totalFormateado = '$ ' + totalVentas.toLocaleString('es-CO');

    var spark1 = {
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
            text: 'Ventas Totales Mayo / Bulevar',
            offsetX: 30,
            style: {
                fontSize: '14px',
                cssClass: 'apexcharts-yaxis-title'
            }
        }
    };

    new ApexCharts(document.querySelector("#spark1"), spark1).render();
}