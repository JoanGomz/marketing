export function cardConversations() {
    // Datos de ventas
    var user = window.user;
    let data = window.chartConversations;
    var spark1 = {
        series: [{
            name: 'Conversaciones',
            data: data.chart_data.series
        }],
        chart: {
            height: (user.role_id === 1) ? 400 : 300,
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
        xaxis: {
            labels: {
                rotate: -45
            },
            categories: data.chart_data.labels,
            tickPlacement: 'on'
        },
        yaxis: {
            title: {
                text: 'Conversaciones',
            },
        },
        title: {
            text: 'Conversaciones por sede',
            align: 'center',
            margin: 20,
            style: {
                fontSize: '16px',
                fontWeight: 600,
                color: '#263238'
            }
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