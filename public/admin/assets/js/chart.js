$(document).ready(function () {
    var filterChanged = false;
    var selectedTerm = 1; // Simpan selectedTerm dalam variabel global

    $("#termSelect").change(function () {
        selectedTerm = $(this).val(); // Update selectedTerm saat filter dipilih
        updateChart(selectedTerm);
    });

    function updateChart(selectedTerm) {
        // Lakukan permintaan AJAX ke endpoint "/get-items" dengan parameter selectedTerm
        $.ajax({
            url: "/get-items",
            method: "GET",
            data: { term_id: selectedTerm },
            success: function (response) {
                var items = response.items;
                var scales = response.scale;
                var colors = ["#FF0000", "#000000", "#0000FF"];
                var selectedTermId =
                    document.getElementById("termSelect").value;
                if (!filterChanged) {
                    selectedTermId = selectedTerm;
                } else if (selectedTermId) {
                    items = items.filter(function (item) {
                        return selectedTermId.includes(item.m_term_id);
                    });
                } else {
                    items = items.filter(function (item) {
                        return [selectedTerm].includes(item.m_term_id);
                    });
                }
                // Update chart berdasarkan data items yang baru
                // ...
                $.ajax({
                    url: "/get-term",
                    method: "GET",
                    data: { term_id: selectedTerm },
                    success: function (response) {
                        var termData = response.term;
                        var termValue = termData ? termData.term : "";
                        var titleText =
                            "SAI Raw Material Stock Control Report </br> (Term " +
                            " - " +
                            termValue +
                            ")";
                        // Update chart berdasarkan data items yang baru
                        // ...
                        // Update judul chart dengan term yang dipilih dan relasi tabel dari m__term_id
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
                                        return parseFloat(
                                            item.STOCKDAYSPLANPASI
                                        );
                                    }),
                                    dashStyle: "longdash",
                                },
                                {
                                    name: "Stock Days Target (SAI)",
                                    data: items.map(function (item) {
                                        return parseFloat(
                                            item.STOCKDAYSPLANSAI
                                        );
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
                    },
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
    $(document).ready(function () {
        $("#termSelect").change(function () {
            var selectedMonthId = $(this).val();

            // Semua tombol edit
            var editButtons = $(".edit-data-btn");

            // Sembunyikan semua tombol edit terlebih dahulu
            editButtons.hide();

            // Tampilkan tombol edit yang sesuai dengan m_term_id yang dipilih
            editButtons
                .filter("[data-term-id='" + selectedMonthId + "']")
                .show();
        });
    });
    function updateFormInputs(selectedTerm) {
        // Lakukan permintaan AJAX ke endpoint "/get-term" dengan parameter selectedTerm
        $.ajax({
            url: "/get-term",
            method: "GET",
            data: { term_id: selectedTerm },
            success: function (response) {
                // Kode update form inputs
                // ...
                var items = response.items;

                // Perbarui nilai elemen form sesuai dengan data items yang diterima
                // Contoh: perbarui nilai input dengan ID "inputField"
                $("#termDropdown").val(items);
            },
        });
    }
    updateFormInputs(1);
    $(document).on("click", ".dropdown-item", function (e) {
        e.preventDefault();
        var itemId = $(this).data("bs-target").split("#modalUpdate")[1];
        updateFormInputs(itemId);
        // console.log(itemId);
        if ($("#modalUpdate").length > 0) {
            $("#modalUpdate").modal("show");

            // Lakukan permintaan AJAX setelah memastikan elemen #modalUpdate ada dalam DOM
            $.ajax({
                type: "GET",
                url: "/edit-chart/" + itemId,
                success: function (response) {
                    // console.log(response);
                    if (response.status == 404) {
                        $("#success_message").html("");
                        $("#success_message").addClass("alert alert-danger");
                        $("#success_message").text(response.message);
                    } else {
                        $("#edit_pasi").val(response.items.STOCKDAYSPLANPASI);
                        $("#edit_sai").val(response.items.STOCKDAYSPLANSAI);
                        $("#edit_act").val(response.items.STOCKDAYSACT);
                        $("#edit_chart_id").val(itemId);
                        $("#term_id").val(response.items.m_term_id);
                        // console.log(response.items.date);
                        // Update teks pada elemen <span> untuk menampilkan bulan dan tahun yang dipilih
                        var dateObj = new Date(response.items.date);
                        var monthNames = [
                            "January",
                            "February",
                            "March",
                            "April",
                            "May",
                            "June",
                            "July",
                            "August",
                            "September",
                            "October",
                            "November",
                            "December",
                        ];
                        var formattedMonth = monthNames[dateObj.getMonth()];
                        var formattedYear = dateObj.getFullYear();

                        // Update teks pada elemen <span> untuk menampilkan nama bulan dan tahun
                        $("#editedMonth").text(
                            formattedMonth + " " + formattedYear
                        );
                    }
                },
            });
        }
    });

    $(document).on("click", ".update_chart", function (e) {
        e.preventDefault();
        var itemId = $("#edit_chart_id").val();
        var term = $("#term_id").val();
        var data = {
            STOCKDAYSPLANPASI: $("#edit_pasi").val(),
            STOCKDAYSPLANSAI: $("#edit_sai").val(),
            STOCKDAYSACT: $("#edit_act").val(),
        };

        $.ajaxSetup({
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
            },
        });

        $.ajax({
            type: "PUT",
            url: "/update-chart/" + itemId,
            data: data,
            dataType: "json",
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
            },
            success: function (response) {
                // console.log(response);
                if (response.status == 400) {
                    $("#updateform_errList").html("");
                    $("#updateform_errList").addClass("alert alert-danger");
                    $.each(response.errors, function (key, err_values) {
                        $("#updateform_errList").append(
                            "<li>" + err_values + "</li>"
                        );
                    });
                } else if (response.status == 404) {
                    $("#updateform_errList").html("");
                    $("#success_message").addClass("alert alert-success");
                    $("#success_message").text(response.message);
                } else {
                    $("#updateform_errList").html("");
                    // $("#success_message").html("");
                    // $("#success_message").addClass("alert alert-success");
                    // $("#success_message").text(response.message);

                    $("#modalUpdate").modal("hide");

                    // Panggil kembali updateChart untuk memperbarui chart setelah berhasil melakukan update
                    updateChart(term);
                }
            },
        });
    });
});
