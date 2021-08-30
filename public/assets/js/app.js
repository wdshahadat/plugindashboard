let baseurl = document.querySelector('meta[name="base-url"]').content;

// call plugin http request to get plugin info
$(document).on("click", "#getInfo", function (e) {
    let slug = $('select[name="slug"]').val();
    let dateRange = $("#dateRange").val();
    
    if (slug !== "0" && dateRange.length > 20) {
        this.setAttribute("disabled", "disabled");
        $(".box-container>div>div, .main-chart > div").addClass("pre-l");
        axios
            .post(`${baseurl}plugin/info`, { slug, dateRange })
            .then((response) => {
                $("#getInfo").removeAttr("disabled");
                chartHandle(response);
            });
    } else {
        toastr.error(
            "Sorry! Please fill all required fields first then search."
        );
    }
});

function chartHandle(response) {
    var cartDom = document.getElementById("pluginChart");
    var labels = Object.keys(response.data.activation);
    var activationData = Object.values(response.data.activation);
    var deactivationData = activationData.map((deactivation) =>
        deactivation < 0 ? Math.abs(deactivation) : 0
    );
    activationData = activationData.map((activation) =>
        activation < 0 ? 0 : activation
    );

    $(".box-container>div>div, .main-chart > div").removeClass("pre-l");
    if (response.data.activation.length < 1) {
        toastr.info("Sorry! Plugin info not available.");
    }

    $(".totalDownload").text(response.data.totalDownload);
    $(".deactivation-rate h1").text(response.data.totalDeactivate + "%");
    $(".activation-rate h1").text(response.data.totalActivate + "%");
    $(".totalActivate, .activated h1").text(
        numberFormat(response.data.totalActivate * 1000)
    );
    $(".deactivated h1").text(
        numberFormat(response.data.totalDeactivate * 1000)
    );

    $(".selected-plugin-text").text(
        $('select[name="slug"] option:selected').text()
    );

    new Chart(cartDom, {
        type: "line",
        data: {
            labels,
            datasets: [
                {
                    label: "Activation",
                    data: activationData.map((val) =>
                        val < 0 ? 0 : val * 1000
                    ),
                    fill: false,
                    borderColor: "#5ec864",
                    tension: 0.3,
                },
                {
                    label: "Deactivation",
                    data: deactivationData.map((val) =>
                        val < 0 ? 0 : val * 1000
                    ),
                    fill: false,
                    borderColor: "#eb5d7a",
                    tension: 0.3,
                },
            ],
        },
        options,
    });

    var options = {
        showLine: false,
        legend: {
            display: false,
        },
        tooltips: {
            enabled: false,
        },
        plugins: {
            legend: {
                display: false,
            },
        },
        scales: {
            xAxes: [
                {
                    gridLines: {
                        display: false,
                    },
                },
            ],
            yAxes: [
                {
                    gridLines: {
                        display: false,
                    },
                },
            ],
        },
    };

    new Chart(document.getElementById("activationRate"), {
        type: "bar",
        data: {
            labels: labels.map((l) => ""),
            datasets: [
                {
                    label: "",
                    data: activationData,
                    fill: false,
                    borderColor: "green",
                },
            ],
        },
        options,
    });

    new Chart(document.getElementById("deactivationRate"), {
        type: "line",
        data: {
            // to empty label
            labels: labels.map((label) => ""),
            datasets: [
                {
                    label: "",
                    data: deactivationData,
                    fill: false,
                    borderColor: "red",
                },
            ],
        },
        options,
    });

    new Chart(document.getElementById("activated"), {
        type: "line",
        data: {
            // to empty label
            labels: labels.map((label) => ""),
            datasets: [
                {
                    label: "",
                    data: activationData.map((val) =>
                        val < 0 ? 0 : val * 1000
                    ),
                    fill: false,
                    borderColor: "green",
                },
            ],
        },
        options,
    });

    new Chart(document.getElementById("deactivated"), {
        type: "line",
        data: {
            // to empty label
            labels: labels.map((label) => ""),
            datasets: [
                {
                    label: "",
                    data: deactivationData.map((val) =>
                        val < 0 ? 0 : val * 1000
                    ),
                    fill: false,
                    borderColor: "#e14674",
                },
            ],
        },
        options,
    });
}

function numberFormat(number) {
    return new Intl.NumberFormat().format(number);
}
