$(document).ready(function () {
    // Membuat fungsi untuk mengubah chart berdasarkan m_month_id
    function updateChart(m_month_id) {
        $.ajax({
            url: "/chartuser/" + m_month_id,
            method: "GET",
            success: function (response) {
                var items = response.items;
                var monthData = response.months;
                var scales = response.scale;
                var monthValue = monthData ? monthData.bulan : "";
                console.log(monthData);
                var colors = ["#FF0000", "#000000", "#0000FF"];
                function formatDate(dateString) {
                    var dateObject = new Date(dateString);
                    var monthYear = dateObject.toLocaleString("default", {
                        month: "long",
                        year: "numeric",
                    });
                    return monthYear;
                }
                // Update judul chart dengan term yang dipilih
                var title =
                    "SAI RAW MATERIAL STOCK CONTROL REPORT (" +
                    formatDate(monthValue) +
                    ")";

                // Update chart berdasarkan data items yang baru
                Highcharts.chart("container", {
                    chart: {
                        type: "line",
                    },
                    title: {
                        text: title,
                    },
                    legend: {
                        symbolWidth: 80,
                    },
                    colors: colors,
                    plotOptions: {
                        series: {
                            colors: colors,
                            dataLabels: {
                                enabled: true,
                            },
                            line: {
                                dataLabels: {
                                    enabled: true,
                                },
                            },
                        },
                    },
                    yAxis: {
                        min: parseFloat(scales.min), // Nilai minimum yang ditampilkan pada sumbu y
                        max: parseFloat(scales.max), // Nilai maksimum yang ditampilkan pada sumbu y
                    },
                    xAxis: {
                        categories: items.map(function (item) {
                            return "Week - " + item.week;
                        }),
                        title: {
                            text: "week",
                        },
                        labels: {
                            enabled: true,
                        },
                    },
                    series: [
                        {
                            name: "STOCK DAYS TARGET (PASI)",
                            data: items.map(function (item) {
                                return parseFloat(item.STOCKDAYSPLANPASI);
                            }),
                            dashStyle: "longdash",
                        },
                        {
                            name: "STOCK DAYS TARGET (SAI)",
                            data: items.map(function (item) {
                                return parseFloat(item.STOCKDAYSPLANSAI);
                            }),
                            dashStyle: "shortdot",
                        },
                        {
                            name: "STOCK DAYS ACTUAL",
                            data: items.map(function (item) {
                                return parseFloat(item.STOCKDAYSACT);
                            }),
                            dashStyle: "solid",
                        },
                    ],
                });
            },
            error: function (xhr, status, error) {
                // Handle any error that might occur during the AJAX request
                console.error(error);
            },
        });
    }

    // Ketika halaman pertama kali dimuat, panggil fungsi updateChart dengan m_month_id = 1
    updateChart(1);

    // Tambahkan event listener ketika select option berubah
    $("#selectMonth").on("change", function () {
        var m_month_id = $(this).val();
        updateChart(m_month_id);
    });
});
