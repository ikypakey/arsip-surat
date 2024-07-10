$(document).ready(function () {
    // Membuat fungsi untuk mengubah chart berdasarkan m_month_id
    function updateChart(m_month_id) {
        $.ajax({
            url: "/chart/" + m_month_id,
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
                            text: "Week",
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
    $(document).ready(function () {
        $("#selectMonth").change(function () {
            var selectedMonthId = $(this).val();

            // Semua tombol edit
            var editButtons = $(".edit-data-btn");

            // Sembunyikan semua tombol edit terlebih dahulu
            editButtons.hide();

            // Tampilkan tombol edit yang sesuai dengan m_month_id yang dipilih
            editButtons
                .filter("[data-month-id='" + selectedMonthId + "']")
                .show();
        });
    });

    function updateFormInputs(m_month_id) {
        $.ajax({
            type: "GET",
            url: "/chart/" + m_month_id, // Replace with the actual URL to fetch item data
            success: function (response) {
                if (response.status === "success") {
                    // Assuming the response has fields like STOCKDAYSPLANPASI, STOCKDAYSPLANSAI, STOCKDAYSACT
                    $("#edit_pasi").val(response.data.STOCKDAYSPLANPASI);
                    $("#edit_sai").val(response.data.STOCKDAYSPLANSAI);
                    $("#edit_act").val(response.data.STOCKDAYSACT);
                }
            },
        });
    }
    $(document).ready(function () {
        $(".edit-data-btn").click(function () {
            var itemwId = $(this).data("itemw-id");
            updateFormInputs(itemwId);

            $.ajax({
                type: "GET",
                url: "/edit-week/" + itemwId,
                success: function (response) {
                    if (response.status == 404) {
                        // Handle error case if necessary
                    } else {
                        $("#edit_pasi").val(response.items.STOCKDAYSPLANPASI);
                        $("#edit_sai").val(response.items.STOCKDAYSPLANSAI);
                        $("#edit_act").val(response.items.STOCKDAYSACT);
                        $("#edit_chart_id").val(itemwId);
                        $("#month_id").val(response.items.m_month_id);
                        var monthData = response.months;
                        var monthValue = monthData ? monthData.bulan : "";

                        function formatDate(dateString) {
                            var dateObject = new Date(dateString);
                            var monthYear = dateObject.toLocaleString(
                                "default",
                                {
                                    month: "long",
                                    year: "numeric",
                                }
                            );
                            return monthYear;
                        }

                        $("#editedMonth").text(formatDate(monthValue));
                        $("#editedWeek").text(response.items.week);
                    }
                },
            });

            $("#modalUpdate").modal("show");
        });

        $("#updateChartButton").click(function (e) {
            e.preventDefault();
            var itemId = $("#edit_chart_id").val();
            var month = $("#month_id").val();
            // console.log(itemId);
            var data = {
                STOCKDAYSPLANPASI: $("#edit_pasi").val(),
                STOCKDAYSPLANSAI: $("#edit_sai").val(),
                STOCKDAYSACT: $("#edit_act").val(),
            };

            $.ajaxSetup({
                headers: {
                    "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr(
                        "content"
                    ),
                },
            });

            $.ajax({
                type: "PUT",
                url: "/update-week/" + itemId,
                data: data,
                dataType: "json",
                success: function (response) {
                    // Handle success response
                    $("#modalUpdate").modal("hide");
                    // Perform any additional actions or updates after successful update
                    console.log(month);
                    updateChart(month);
                },
                error: function (xhr) {
                    // Handle error response
                    // Display error messages if necessary
                    var errors = xhr.responseJSON.errors;
                    var errorList = $("#updateform_errList");
                    errorList.empty();
                    $.each(errors, function (key, value) {
                        errorList.append("<li>" + value + "</li>");
                    });
                },
            });
        });
    });

    // Tambahkan event listener ketika select option berubah
    $("#selectMonth").on("change", function () {
        var m_month_id = $(this).val();
        updateChart(m_month_id);
    });
});
