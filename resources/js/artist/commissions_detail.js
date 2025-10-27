function setCommissionStatus(commissionId, status) {
    $.ajax({
        url: `/artist/commissions/status/${commissionId}`,
        type: "POST",
        data: {
            status: status,
            // No need to manually include _token anymore
            // The global $.ajaxSetup in app.js handles X-CSRF-TOKEN header automatically
        },
        success: function (response) {
            notie.alert({
                type: "success",
                text:
                    "Updated Commission Status to '" +
                    status +
                    "'. Reloading...",
            });
            setTimeout(() => location.reload(), 1000);
        },
        error: function (xhr, status, error) {
            notie.alert({
                type: "error",
                text: "An error occurred while updating the commission status.",
            });
            console.error("Status update error:", xhr.responseJSON || error);
        },
    });
}

$(document).ready(function () {
    $("#accept-commission-btn").click(function () {
        const commissionId = $(this).data("commission-id");
        setCommissionStatus(commissionId, "accepted");
    });

    $("#decline-commission-btn").click(function () {
        const commissionId = $(this).data("commission-id");
        setCommissionStatus(commissionId, "cancelled");
    });
});
