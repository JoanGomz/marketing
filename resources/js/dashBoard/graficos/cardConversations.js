export function cardConversations() {
    // Datos de ventas
    var user = window.user;
    
    var spark1 = {
        series: [{
            name: 'Conversaciones',
            data: [44, 55, 41, 67, 22, 43, 21, 33, 45]
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