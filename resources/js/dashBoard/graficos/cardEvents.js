export function cardEvents() {
    var user = window.user;
    let data = window.chartEvents;
    console.log(data);
    
    var options = {
        series: data.pie_chart.series,
        labels: data.pie_chart.labels,
        chart: {
            type: 'donut',
            height: 450,
            width: '100%'
        },
        colors: ['#B31F28', '#0078B6', '#180c44', '#581c94'],
        
        plotOptions: {
            pie: {
                donut: {
                    size: '60%',
                    labels: {
                        show: true,
                        name: {
                            show: true,
                            fontSize: '16px',
                            fontWeight: 600,
                            color: '#373d3f'
                        },
                        value: {
                            show: true,
                            fontSize: '20px',
                            fontWeight: 700,
                            color: '#373d3f',
                            formatter: function (val) {
                                return Math.round(val) + '%'
                            }
                        },
                        total: {
                            show: true,
                            showAlways: true,
                            label: 'Total',
                            fontSize: '14px',
                            fontWeight: 600,
                            color: '#373d3f',
                            formatter: function (w) {
                                return w.globals.seriesTotals.reduce((a, b) => {
                                    return a + b
                                }, 0)
                            }
                        }
                    }
                }
            }
        },
        
        dataLabels: {
            enabled: true,
            formatter: function (val) {
                return Math.round(val) + '%'
            },
            style: {
                fontSize: '12px',
                fontWeight: 600,
                colors: ['#fff']
            },
            dropShadow: {
                enabled: true
            }
        },
        
        legend: {
            show: true,
            position: 'bottom',
            horizontalAlign: 'center',
            fontSize: '12px',
            fontWeight: 500,
            markers: {
                width: 12,
                height: 12,
                radius: 12
            },
            itemMargin: {
                horizontal: 10,
                vertical: 5
            }
        },
        
        title: {
            text: 'Distribución de Eventos',
            align: 'center',
            margin: 20,
            style: {
                fontSize: '16px',
                fontWeight: 600,
                color: '#263238'
            }
        },
        
        // Tooltip simplificado - solo muestra la cantidad
        tooltip: {
            y: {
                formatter: function(val) {
                    return val + " eventos"; // Solo cantidad, sin porcentaje
                }
            }
        },
        
        // Sin efectos de hover especiales
        states: {
            hover: {
                filter: {
                    type: 'none' // Quita los efectos de hover
                }
            },
            active: {
                filter: {
                    type: 'none' // Quita los efectos de active
                }
            }
        },
        
        responsive: [{
            breakpoint: 768,
            options: {
                chart: {
                    height: 300
                },
                legend: {
                    position: 'bottom',
                    fontSize: '10px'
                },
                title: {
                    style: {
                        fontSize: '14px'
                    }
                }
            }
        }, {
            breakpoint: 480,
            options: {
                chart: {
                    height: 250
                },
                legend: {
                    fontSize: '9px'
                },
                dataLabels: {
                    enabled: false
                }
            }
        }],
        
        animations: {
            enabled: true,
            easing: 'easeinout',
            speed: 800,
            animateGradually: {
                enabled: true,
                delay: 150
            },
            dynamicAnimation: {
                enabled: true,
                speed: 350
            }
        }
    };

    var chart = new ApexCharts(document.querySelector("#chart2"), options);
    chart.render();
}