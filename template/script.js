


$(function () {

    $(document).ready(function () {

         $('#addLe').click(function(){
            var chart = $('#chart').highcharts();
            var val1 = chart.series[0].data[0].y+1;
            var val2 = chart.series[0].data[1].y;
            chart.series[0].setData([val1, val2]);
            console.log("Le: " + val1 + "; La: " +val2);
         });

         $('#addLa').click(function(){
            var chart = $('#chart').highcharts();
            var val1 = chart.series[0].data[0].y;
            var val2 = chart.series[0].data[1].y+1;
            chart.series[0].setData([val1, val2]);
            console.log("Le: " + val1 + "; La: " +val2);
         });


        // Build the chart
        $('#chart').highcharts({
            chart: {
                plotBackgroundColor: null,
                plotBorderWidth: null,
                plotShadow: false,
                type: 'pie'
            },
            title: {
                text: 'Résultat'
            },
            tooltip: {
                pointFormat: '<b>{point.percentage:.1f}%</b>'
            },
            plotOptions: {
                pie: {
                    allowPointSelect: true,
                    cursor: 'pointer',
                    dataLabels: {
                        enabled: false
                    },
                    showInLegend: true
                }
            },
            series: [{
                name: 'Valeur',
                colorByPoint: true,
                data: [{
                    name: 'Le',
                    y: 0,
                    color: "#6DBCDB"
                }, {
                    name: 'La',
                    y: 0,
                    color: "#FC4349"
                }]
            }]
        });



    });


});