$(document).ready(function () {
    var filterChanged = false;
    var selectedTerm = 1; // Simpan selectedTerm dalam variabel global

    function updateChart(m_term_id) {
        var id = m_term_id;
        var url = "{{ route('get-items-user', ':id') }}";
        url = url.replace(":id", id);
        $.ajax({
            enctype: "multipart/form-data",
            url: url,
            method: "GET",
            success: function (response) {
                var items = response.items;
                var scales = response.scale;
                var colors = ["#FF0000", "#000000", "#0000FF"];
                var termData = response.mterm;
                var termValue = termData ? termData.term : "";
                var titleText =
                    "SAI Raw Material Stock Control Report </br> (Term " +
                    " - " +
                    termValue +
                    ")";
                Highcharts.chart("container", {
                    chart: {
                        type: "line",
                    },
                    title: {
                        text: titleText,
                    },
                    legend: {
                        symbolWidth: 80,
                    },
                    colors: colors,
                    plotOptions: {
                        series: {
                            lineWidth: 2,
                            colors: colors,
                        },
                        line: {
                            dataLabels: {
                                enabled: true,
                            },
                        },
                    },
                    yAxis: {
                        min: parseFloat(scales.min), // Nilai minimum yang ditampilkan pada sumbu y
                        max: parseFloat(scales.max), // Nilai maksimum yang ditampilkan pada sumbu y
                    },
                    xAxis: {
                        categories: items.map(function (item) {
                            var date = new Date(item.date);
                            var month = date
                                .toLocaleString("default", {
                                    month: "long",
                                })
                                .slice(0, 3);
                            var year = date.getFullYear();
                            return month + "-" + year;
                        }),
                        title: {
                            text: "Month",
                        },
                        labels: {
                            enabled: true,
                        },
                    },
                    series: [
                        {
                            name: "Stock Days Target (PASI)",
                            data: items.map(function (item) {
                                return parseFloat(item.STOCKDAYSPLANPASI);
                            }),
                            dashStyle: "longdash",
                        },
                        {
                            name: "Stock Days Target (SAI)",
                            data: items.map(function (item) {
                                return parseFloat(item.STOCKDAYSPLANSAI);
                            }),
                            dashStyle: "shortdot",
                        },
                        {
                            name: "Stock Days Actual",
                            data: items.map(function (item) {
                                return parseFloat(item.STOCKDAYSACT);
                            }),
                            dashStyle: "solid",
                        },
                    ],
                });
                // Update data input pada form
            },
        });
    }
    updateChart(selectedTerm);
    $("#termSelect").change(function () {
        var selectedTermId = $(this).val();
        updateFormInputs(selectedTermId);
    });
});
