var colors = ["#FF0000", "#0000FF", "#0000FF"];
var myurl = $("#myurl").attr("url");
Highcharts.chart("container", {
    chart: {
        zoomType: "xy",
    },
    title: {
        text: "SAI RAW MATERIAL STOCK CONTROL REPORT </br> (2023)",
    },

    legend: {
        symbolWidth: 80,
    },

    colors: colors,
    plotOptions: {
        series: {
            lineWidth: 2,
            colors: colors,
            format: "{point.y:.3f}%",
        },
        line: {
            dataLabels: {
                enabled: true,
                // format: "{point.y:.3f}%",
            },
        },
        column: {
            dataLabels: {
                enabled: true,
                format: "{point.y:.3f}%",
            },
        },
    },
    yAxis: {
        min: 0, // Nilai minimum yang ditampilkan pada sumbu y
        max: 0.1, // Nilai maksimum yang ditampilkan pada sumbu y
        title: {
            text: "%",
        },
    },
    xAxis: {
        categories: [
            "Jan-23",
            "Feb-23",
            "Mar-23",
            "Apr-23",
            "May-23",
            "Jun-23",
            "Jul-23",
            "Aug-23",
            "Sep-23",
            "Oct-23",
            "Nov-23",
            "Dec-23",
        ],
        title: {
            text: "</br> Year 2023",
        },
        labels: {
            enabled: true,
        },
    },
    series: [
        {
            name: "Stcok Days Target (PASI)",
            data: [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0],
            dashStyle: "longdash",
            zIndex: 2,
        },
        {
            name: "Stock Days Actual",
            data: [0.017, 0.016, 0.015, 0.014, 0.022, 0.019, 0.023, 0.022],
            type: "column",
            zIndex: 1,
            events: {
                click: function (event) {
                    var dateParts = event.point.category;
                    console.log(dateParts);
                    if (dateParts === "Aug-23") {
                        window.location.href = myurl;
                    } else {
                        return false;
                    }
                },
            },
        },
    ],
});
