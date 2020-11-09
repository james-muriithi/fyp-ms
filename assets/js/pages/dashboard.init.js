!function(d) {
    "use strict";

    async function doghnutChart() {
        let ctx = document.getElementById('ct-donut');
        let projects= await fetch('../api/project').then(res => res.json()).then(d => {
            let p = []
            Object.keys(d).forEach((item, index) => {
                p[index] = d[item].length
            })
            return p;
        })
        if (ctx){
            //    chart
            let data = {
                datasets: [{
                    data: await projects.slice(0,3),
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
        }
    }

    doghnutChart()



    function r() {}
    r.prototype.respChart = function(r, o, e, a) {
        Chart.defaults.global.defaultFontColor = "#adb5bd", Chart.defaults.scale.gridLines.color = "rgba(108, 120, 151, 0.1)";
        var t = r.get(0).getContext("2d"),
            n = d(r).parent();

        function i() {
            r.attr("width", d(n).width());
            switch (o) {
                case "Radar":
                    new Chart(t, { type: "radar", data: e, options: a });
                    break;
            }
        }
        d(window).resize(i), i()
    }, r.prototype.init = async function() {
        let projects= await fetch('../api/project').then(res => res.json()).then(d => {
            let p = []
            Object.keys(d).forEach((item, index) => {
                p[index] = d[item].length
            })
            return p;
        })
        this.respChart(d("#radar"), "Radar", {
            labels: ["Unassigned", "Assigned","Completed", "Ongoing", "Rejected"],
            datasets: [{ label: "Projects",fill: true, backgroundColor: "rgba(102, 51, 153, 0.4)",
                borderColor: "#3c4ccf", pointBackgroundColor: "#3c4ccf", pointBorderColor: "#fff",
                pointHoverBackgroundColor: "#fff", pointHoverBorderColor: "#3c4ccf",
                data: await projects.slice(3,8) }] },{
            scale: {
                ticks: {
                    callback: function (tick) {
                        if (tick.toString().indexOf('.') < 0){return tick}
                        return '';
                    }
                }
            }
        });
    }, d.ChartJs = new r, d.ChartJs.Constructor = r
}(window.jQuery),
    function() {
        "use strict";
        window.jQuery.ChartJs.init()
    }();
