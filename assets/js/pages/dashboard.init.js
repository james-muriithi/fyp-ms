// new Chartist.Line("#chart-with-area",{labels:[1,2,3,4,5,6,7,8],series:[[5,9,7,8,5,3,5,4]]},{low:0,showArea:!0,plugins:[Chartist.plugins.tooltip()]});var chart=new Chartist.Pie("#ct-donut",{series:[54,28,17],labels:[1,2,3]},{donut:!0,showLabel:!1,plugins:[Chartist.plugins.tooltip()]});$(".peity-donut").each(function(){$(this).peity("donut",$(this).data())}),$(".peity-line").each(function(){$(this).peity("line",$(this).data())});
let ctx = document.getElementById('ct-donut');
let projects= [0,0,0];
if (ctx){
    $.ajax({
        type: 'get',
        headers:{
            'Content-Type': 'application/json'
        },
        url: '../api/project/',
        success: d => {
            try{
                d = JSON.parse(d)
                projects[0] = d['webArr'].length
                projects[1] = d['androidArr'].length
                projects[2] = d['desktopArr'].length

                //    chart
                let data = {
                    datasets: [{
                        data: projects,
                        backgroundColor:[
                            '#ff6384',
                            '#36a2eb',
                            '#ffce56'
                        ]
                    }],

                    // These labels appear in the legend and in the tooltips when hovering different arcs
                    labels: [
                        'Web Apps',
                        'Android Apps',
                        'Desktop Apps'
                    ]
                }
                let myDoughnutChart = new Chart(ctx, {
                    type: 'doughnut',
                    data: data,
                    options:{

                    }
                });
                let chartData = myDoughnutChart.data.datasets[0].data;

                let total = chartData.reduce((previousValue, currentValue)=> previousValue + currentValue);

                let percentageArray = []
                chartData.forEach(item =>{
                    try{
                        let percentage = ((Number(item)/total) * 100).toFixed(1)
                        percentageArray.push(`${percentage}%`)
                    }   catch (e) {
                        console.log(e)
                    }
                })

                $('td.w-app').text(percentageArray[0]);
                $('td.d-app').text(percentageArray[2]);
                $('td.a-app').text(percentageArray[1]);
                //    end chart



            }catch (e) {
                console.log(e)
            }
        },
        error : data =>{
            console.log(data)
        }
    })
}