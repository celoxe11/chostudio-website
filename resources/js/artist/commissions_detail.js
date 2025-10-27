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

    $("#update-progress-btn").click(function () {
        const status = $("#update-progress-select").val();
        const commissionId = $(this).data("commission-id");
        setCommissionStatus(commissionId, status);
    });

    // Handle payment status update
    $("#update-payment-btn").click(function () {
        const paymentStatus = $("#update-payment-select").val();
        const commissionId = $(this).data("commission-id");

        // Disable button during submission
        $(this)
            .prop("disabled", true)
            .html(
                '<div class="flex items-center justify-center gap-2"><svg class="animate-spin h-4 w-4" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>Saving...</div>'
            );

        $.ajax({
            url: `/artist/commissions/payment/${commissionId}`,
            type: "POST",
            data: {
                payment_status: paymentStatus,
            },
            success: function (response) {
                notie.alert({
                    type: "success",
                    text:
                        "Updated Payment Status to '" +
                        paymentStatus +
                        "'. Reloading...",
                });
                setTimeout(() => location.reload(), 1000);
            },
            error: function (xhr, status, error) {
                notie.alert({
                    type: "error",
                    text: "An error occurred while updating the payment status.",
                });
                console.error(
                    "Payment status update error:",
                    xhr.responseJSON || error
                );
                $("#update-payment-btn")
                    .prop("disabled", false)
                    .html(
                        '<div class="flex items-center justify-center gap-2"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>Save</div>'
                    );
            },
        });
    });

    $("#cancel-commission-btn").click(function () {
        const section = $("#cancellation-reason-section");
        section.toggleClass("hidden");

        // Add smooth slide animation
        if (!section.hasClass("hidden")) {
            section.hide().removeClass("hidden").slideDown(300);
            $("#cancellation-reason-textarea").focus();
        }
    });

    // Handle cancel button in the cancellation section
    $("#cancel-cancellation-btn").click(function () {
        $("#cancellation-reason-section").slideUp(300, function () {
            $(this).addClass("hidden");
            $("#cancellation-reason-textarea").val("");
        });
    });

    // Handle submit cancellation
    $("#submit-cancellation-btn").click(function () {
        const commissionId = $("#cancel-commission-btn").data("commission-id");
        const reason = $("#cancellation-reason-textarea").val().trim();

        if (!reason) {
            notie.alert({
                type: "warning",
                text: "Please provide a cancellation reason.",
            });
            $("#cancellation-reason-textarea").focus();
            return;
        }

        // Disable button during submission
        $(this)
            .prop("disabled", true)
            .html(
                '<div class="flex items-center justify-center gap-2"><svg class="animate-spin h-5 w-5" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>Processing...</div>'
            );

        $.ajax({
            url: `/artist/commissions/cancel/${commissionId}`,
            type: "POST",
            data: {
                reason: reason,
            },
            success: function (response) {
                notie.alert({
                    type: "success",
                    text: "Commission cancelled successfully. Reloading...",
                });
                setTimeout(() => location.reload(), 1000);
            },
            error: function (xhr, status, error) {
                notie.alert({
                    type: "error",
                    text: "An error occurred while cancelling the commission.",
                });
                console.error("Cancellation error:", xhr.responseJSON || error);
                $("#submit-cancellation-btn")
                    .prop("disabled", false)
                    .html(
                        '<div class="flex items-center justify-center gap-2"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>Confirm Cancellation</div>'
                    );
            },
        });
    });
});
