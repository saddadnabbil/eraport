$(function () {
    // ==============================================================
    // Campaign Jenis Kelamin
    // ==============================================================
    var siswaData = JSON.parse(
        document
            .getElementById("campaign-jenis_kelamin")
            .getAttribute("data-siswa")
    );

    var chart2 = c3.generate({
        bindto: "#campaign-jenis_kelamin",
        data: {
            columns: siswaData,
            type: "donut",
            tooltip: {
                show: true,
            },
        },
        donut: {
            label: {
                show: false,
            },
            title: "Jenis Kelamin",
            width: 18,
        },

        legend: {
            hide: true,
        },
        color: {
            pattern: [
                "#edf2f6",
                "rgb(255,79,112)",
                "rgb(34,202,128)",
                "rgb(1,202,241)",
                "rgb(251,140,0)",
            ],
        },
    });

    d3.select("#campaign-jenis_kelamin .c3-chart-arcs-title").style(
        "font-family",
        "Rubik"
    );
});
