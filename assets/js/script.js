jQuery(document).ready(function ($) {
    function showLoading() {
        $(".sidreport-loading").fadeIn();
    }

    function hideLoading() {
        $(".sidreport-loading").fadeOut();
    }

    $("#sidreport-search-btn").on("click", function (e) {
        e.preventDefault();
        let query = $("#sidreport-search-input").val();

        showLoading();
        $.ajax({
            type: "POST",
            url: sidreport_ajax.ajax_url,
            data: { action: "sidreport_search", query: query },
            success: function (response) {
                $("#sidreport-search-results").html(response);
                hideLoading();
            }
        });
    });
});
