$(document).ready(function(){
    
    /* Make some random data for Flot Line Chart*/
    
    var data1 = [[1,60]];
    var data2 = [[1,20]];
    var data3 = [[1,100]];
    var data4 = [[1,50]];
    var data5 = [[1,70]];
    var data6 = [[1,90]];
    var data7 = [[1,30]];
    var data8 = [[1,90]];
    var data9 = [[1,20]];
    var data10 = [[1,100]];

    
    /* Create an Array push the data + Draw the bars*/
    
    var barData = new Array();

    barData.push({
            data : data1,
            label: 'Aceh',
            bars : {
                    show : true,
                    barWidth : 0.08,
                    order : 1,
                    lineWidth: 0,
                    fillColor: '#8BC34A'
            }
    });
    
    barData.push({
            data : data2,
            label: 'Sumatera Utara',
            bars : {
                    show : true,
                    barWidth : 0.08,
                    order : 2,
                    lineWidth: 0,
                    fillColor: '#8BC34A'
            }
    });
    
    barData.push({
            data : data3,
            label: 'Sumatera Barat',
            bars : {
                    show : true,
                    barWidth : 0.08,
                    order : 3,
                    lineWidth: 0,
                    fillColor: '#8BC34A'
            }
    });
    
    barData.push({
            data : data4,
            label: 'Riau',
            bars : {
                    show : true,
                    barWidth : 0.08,
                    order : 4,
                    lineWidth: 0,
                    fillColor: '#8BC34A'
            }
    });
    
    barData.push({
            data : data5,
            label: 'Jambi',
            bars : {
                    show : true,
                    barWidth : 0.08,
                    order : 5,
                    lineWidth: 0,
                    fillColor: '#8BC34A'
            }
    });
    
    barData.push({
            data : data6,
            label: 'Sumatera Selatan',
            bars : {
                    show : true,
                    barWidth : 0.08,
                    order : 6,
                    lineWidth: 0,
                    fillColor: '#8BC34A'
            }
    });
    
    barData.push({
            data : data7,
            label: 'Bengkulu',
            bars : {
                    show : true,
                    barWidth : 0.08,
                    order : 7,
                    lineWidth: 0,
                    fillColor: '#8BC34A'
            }
    });
    
    barData.push({
            data : data8,
            label: 'Lampung',
            bars : {
                    show : true,
                    barWidth : 0.08,
                    order : 8,
                    lineWidth: 0,
                    fillColor: '#8BC34A'
            }
    });
    
    barData.push({
            data : data9,
            label: 'Bangka Belitung',
            bars : {
                    show : true,
                    barWidth : 0.08,
                    order : 9,
                    lineWidth: 0,
                    fillColor: '#8BC34A'
            }
    });

    barData.push({
            data : data10,
            label: 'Kepulauan Riau',
            bars : {
                    show : true,
                    barWidth : 0.08,
                    order : 10,
                    lineWidth: 0,
                    fillColor: '#8BC34A'
            }
    });
    
    /* Let's create the chart */
    if ($('#bar-chart')[0]) {
        $.plot($("#bar-chart"), barData, {
            grid : {
                    borderWidth: 1,
                    borderColor: '#eee',
                    show : true,
                    hoverable : true,
                    clickable : true
            },
            
            yaxis: {
                tickColor: '#eee',
                tickDecimals: 0,
                font :{
                    lineHeight: 13,
                    style: "normal",
                    color: "#9f9f9f",
                },
                shadowSize: 0
            },
            
            xaxis: {
                tickColor: '#fff',
                tickDecimals: 0,
                font :{
                    lineHeight: 13,
                    style: "normal",
                    color: "#9f9f9f"
                },
                shadowSize: 0,
            },
    
            legend:{
                container: '.flc-bar',
                backgroundOpacity: 0.5,
                noColumns: 0,
                backgroundColor: "white",
                lineWidth: 0
            }
        });
    }
    
    /* Tooltips for Flot Charts */
    
    if ($(".flot-chart")[0]) {
        $(".flot-chart").bind("plothover", function (event, pos, item) {
            if (item) {
                var x = item.datapoint[0].toFixed(2),
                    y = item.datapoint[1].toFixed(2);
                $(".flot-tooltip").html(item.series.label + " of " + x + " = " + y).css({top: item.pageY+5, left: item.pageX+5}).show();
            }
            else {
                $(".flot-tooltip").hide();
            }
        });
        
        $("<div class='flot-tooltip' class='chart-tooltip'></div>").appendTo("body");
    }
});