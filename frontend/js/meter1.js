$(document).ready(function () {
    function showChart(data) {
        $('#energy_data').highcharts({
            chart: {
                type: 'area',
                style: {
                    fontSize: '16px'
                }
            },
            title: {
                text: 'Datensammlung Sromzähler 1'
            },
            legend: {
                enabled: false
            },
            series: [{
                    animation: false,
                    name: 'kWh',
                    data: data["data"],
                    style: {
                        fontSize: '18px'
                    }
                }],
            xAxis: {
                allowDecimals: false,
                categories: data["label"],
                style: {
                    fontSize: '18px'
                }
            },
            yAxis: {
                title: {
                    text: 'kWh'
                }
            },
            tooltip: {
                formatter: function () {
                    return 'Um ' + this.x + ' wurden <b>' + this.y + '</b> kWh verbraucht'
                }
            }
        });
        
        $('#sum-data').text("SUM: " + data["sum"][0] + " kWh");
    }

    var lastReport = "d";
    function report(scale) {
        lastReport = scale;
        $.ajax({
            url: 'data.php?scale=' + scale,
            async: true,
            dataType: "json",
            success: function (data) {
                showChart(data);
            }
        });
    }

    $('#daily').click(function () {
        report("d");
    });

    $('#weekly').click(function () {
        report("w");
    });

    $('#monthly').click(function () {
        report("m");
    });

    $('#yearly').click(function () {
        report("y");
    });

    report(lastReport)
    setInterval(function () {
        report(lastReport);
    }, 60000);

    function meterChart(data) {
        $('#current_data').highcharts({
            chart: {
                type: 'gauge',
                plotBackgroundColor: null,
                plotBackgroundImage: null,
                plotBorderWidth: 0,
                plotShadow: false
            },
            title: {
                text: 'Aktueller Stromverbrauch'
            },
            pane: {
                startAngle: -125,
                endAngle: 125,
                background: [{
                        backgroundColor: {
                            linearGradient: {x1: 0, y1: 0, x2: 0, y2: 1},
                            stops: [
                                [0, '#FFF'],
                                [1, '#333']
                            ]
                        },
                        borderWidth: 0,
                        outerRadius: '109%'
                    }, {
                        backgroundColor: {
                            linearGradient: {x1: 0, y1: 0, x2: 0, y2: 1},
                            stops: [
                                [0, '#333'],
                                [1, '#FFF']
                            ]
                        },
                        borderWidth: 1,
                        outerRadius: '107%'
                    }, {
                        // default background
                    }, {
                        backgroundColor: '#DDD',
                        borderWidth: 0,
                        outerRadius: '105%',
                        innerRadius: '103%'
                    }]
            },
            yAxis: {
                min: 0,
                max: 10,
                minorTickInterval: 'auto',
                minorTickWidth: 1,
                minorTickLength: 10,
                minorTickPosition: 'inside',
                minorTickColor: '#666',
                tickPixelInterval: 30,
                tickWidth: 2,
                tickPosition: 'inside',
                tickLength: 10,
                tickColor: '#666',
                labels: {
                    step: 2,
                    rotation: 'auto'
                },
                title: {
                    text: 'kWh'
                },
                plotBands: [{
                        from: 0,
                        to: 3,
                        color: '#55BF3B' // green
                    }, {
                        from: 3,
                        to: 7,
                        color: '#DDDF0D' // yellow
                    }, {
                        from: 7,
                        to: 10,
                        color: '#DF5353' // red
                    }]
            },
            series: [{
                    name: 'kWh',
                    data: [data["data"][0]],
                    tooltip: {
                        valueSuffix: ' kWh'
                    },
                    dataLabels: {
                        enabled: true,
                        style: {
                            //fontWeight:'bold',
                            fontSize: '22px'
                        }
                    }
                }]
        });
    }

    function now() {
        $.ajax({
            url: 'data.php?scale=now',
            async: true,
            dataType: "json",
            success: function (data) {
                meterChart(data);
            }
        });
    }

    now();
    setInterval(function () {
        now();
    }, 60000);

    $(window).resize(function () {
        if ($(window).width() > 1015) {
            //width = $("#energy_data").width() / 2.008
        } else {
            width = $("#energy_data").width();
        }
        width = $("#energy_data").width();
    });
});