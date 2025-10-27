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
            Swal.fire({
                icon: "success",
                title: "Success!",
                text:
                    "Updated Commission Status to '" +
                    getProgressStatusText(status) +
                    "'. Reloading...",
                customClass: {
                    popup: "custom-swal-popup",
                    title: "custom-swal-title",
                    htmlContainer: "custom-swal-text",
                },
            });
            setTimeout(() => location.reload(), 1000);
        },
        error: function (xhr, status, error) {
            Swal.fire({
                icon: "error",
                title: "Error!",
                text: "An error occurred while updating the commission status.",
                customClass: {
                    popup: "custom-swal-popup",
                    title: "custom-swal-title",
                    htmlContainer: "custom-swal-text",
                },
            });
            console.error("Status update error:", xhr.responseJSON || error);
        },
    });
}

function getProgressStatusText(status) {
    const statusTexts = {
        pending: "Pending",
        accepted: "Accepted",
        declined: "Declined",
        in_progress_sketch: "Sketching",
        in_progress_coloring: "Coloring",
        review: "In Review",
        revision: "Revision",
        completed: "Completed",
        cancelled: "Cancelled",
    };
    return statusTexts[status] || "Unknown";
}

function getPaymentStatusText(status) {
    const paymentTexts = {
        pending: "Unpaid",
        dp: "DP",
        paid: "Paid",
        refunded: "Refunded",
    };
    return paymentTexts[status] || "Unknown";
}

$(document).ready(function () {
    $("#accept-commission-btn").click(function () {
        const commissionId = $(this).data("commission-id");
        setCommissionStatus(commissionId, "accepted");
    });

    $("#decline-commission-btn").click(function () {
        const commissionId = $(this).data("commission-id");
        setCommissionStatus(commissionId, "declined");
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
        const button = $(this);

        // Show confirmation dialog
        Swal.fire({
            icon: "question",
            title: "Confirm Payment Status Update",
            text: `Are you sure you want to update the payment status to '${getPaymentStatusText(
                paymentStatus
            )}'?`,
            showCancelButton: true,
            confirmButtonText: "Yes, Update",
            cancelButtonText: "Cancel",
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            customClass: {
                popup: "custom-swal-popup",
                title: "custom-swal-title",
                htmlContainer: "custom-swal-text",
            },
        }).then((result) => {
            if (!result.isConfirmed) {
                return; // User cancelled
            }

            // Disable button during submission
            button
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
                    Swal.fire({
                        icon: "success",
                        title: "Success!",
                        text:
                            "Updated Payment Status to '" +
                            paymentStatus +
                            "'. Reloading...",
                        customClass: {
                            popup: "custom-swal-popup",
                            title: "custom-swal-title",
                            htmlContainer: "custom-swal-text",
                        },
                    });
                    setTimeout(() => location.reload(), 1000);
                },
                error: function (xhr, status, error) {
                    Swal.fire({
                        icon: "error",
                        title: "Error!",
                        text: "An error occurred while updating the payment status.",
                        customClass: {
                            popup: "custom-swal-popup",
                            title: "custom-swal-title",
                            htmlContainer: "custom-swal-text",
                        },
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
        }); // Close the Swal.then() block
    });

    // handle file input change for progress upload
    $("#progress-file-input").change(function () {
        const fileName = $(this).val().split("\\").pop();
        const fileNameDiv = $("#file-name");

        if (fileName) {
            fileNameDiv
                .text(fileName)
                .removeClass("hidden")
                .hide()
                .slideDown(200);
        } else {
            fileNameDiv.slideUp(200, function () {
                $(this).addClass("hidden");
            });
        }
    });

    $("#progress-upload-btn").click(function () {
        const commissionId = $(this).data("commission-id");
        const fileInput = $("#progress-file-input")[0];

        if (fileInput.files.length === 0) {
            Swal.fire({
                icon: "warning",
                title: "No File Selected",
                text: "Please select a file to upload.",
                customClass: {
                    popup: "custom-swal-popup",
                    title: "custom-swal-title",
                    htmlContainer: "custom-swal-text",
                },
            });
            return;
        }

        const formData = new FormData();
        formData.append("image", fileInput.files[0]);
        // Let backend determine stage automatically

        // Disable button during submission
        $(this)
            .prop("disabled", true)
            .html(
                '<div class="flex items-center justify-center gap-2"><svg class="animate-spin h-5 w-5" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>Uploading...</div>'
            );

        $.ajax({
            url: `/artist/commissions/upload/${commissionId}`,
            type: "POST",
            data: formData,
            processData: false,
            contentType: false,
            success: function (response) {
                Swal.fire({
                    icon: "success",
                    title: "Success!",
                    text: "Progress image uploaded successfully. Reloading...",
                    customClass: {
                        popup: "custom-swal-popup",
                        title: "custom-swal-title",
                        htmlContainer: "custom-swal-text",
                    },
                });
                setTimeout(() => location.reload(), 1000);
            },
            error: function (xhr, status, error) {
                Swal.fire({
                    icon: "error",
                    title: "Upload Failed",
                    text:
                        xhr.responseJSON?.message ||
                        "An error occurred while uploading the progress image.",
                    customClass: {
                        popup: "custom-swal-popup",
                        title: "custom-swal-title",
                        htmlContainer: "custom-swal-text",
                    },
                });
                console.error(
                    "Progress upload error:",
                    xhr.responseJSON || error
                );
                $("#progress-upload-btn")
                    .prop("disabled", false)
                    .html(
                        '<div class="flex items-center justify-center gap-2"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>Upload</div>'
                    );
            },
        });
    });

    // handle file input change for revision upload
    $("#revision-file-input").change(function () {
        const fileName = $(this).val().split("\\").pop();
        const fileNameDiv = $("#revision-file-name");

        if (fileName) {
            fileNameDiv
                .text(fileName)
                .removeClass("hidden")
                .hide()
                .slideDown(200);
        } else {
            fileNameDiv.slideUp(200, function () {
                $(this).addClass("hidden");
            });
        }
    });

    $("#revision-upload-btn").click(function () {
        const commissionId = $(this).data("commission-id");
        const fileInput = $("#revision-file-input")[0];

        if (fileInput.files.length === 0) {
            Swal.fire({
                icon: "warning",
                title: "No File Selected",
                text: "Please select a file to upload.",
                customClass: {
                    popup: "custom-swal-popup",
                    title: "custom-swal-title",
                    htmlContainer: "custom-swal-text",
                },
            });
            return;
        }

        const formData = new FormData();
        formData.append("image", fileInput.files[0]);
        formData.append("stage", "sketch_revision"); // Explicitly mark as revision

        // Disable button during submission
        $(this)
            .prop("disabled", true)
            .html(
                '<div class="flex items-center justify-center gap-2"><svg class="animate-spin h-5 w-5" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>Uploading...</div>'
            );

        $.ajax({
            url: `/artist/commissions/upload/${commissionId}`,
            type: "POST",
            data: formData,
            processData: false,
            contentType: false,
            success: function (response) {
                Swal.fire({
                    icon: "success",
                    title: "Success!",
                    text: "Revision image uploaded successfully. Reloading...",
                    customClass: {
                        popup: "custom-swal-popup",
                        title: "custom-swal-title",
                        htmlContainer: "custom-swal-text",
                    },
                });
                setTimeout(() => location.reload(), 1000);
            },
            error: function (xhr, status, error) {
                Swal.fire({
                    icon: "error",
                    title: "Upload Failed",
                    text:
                        xhr.responseJSON?.message ||
                        "An error occurred while uploading the revision image.",
                    customClass: {
                        popup: "custom-swal-popup",
                        title: "custom-swal-title",
                        htmlContainer: "custom-swal-text",
                    },
                });
                console.error(
                    "Revision upload error:",
                    xhr.responseJSON || error
                );
                $("#revision-upload-btn")
                    .prop("disabled", false)
                    .html(
                        '<div class="flex items-center justify-center gap-2"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>Upload</div>'
                    );
            },
        });
    });

    // Handle cancel commission button
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

        if (!reason || reason.length === 0 || reason === "") {
            Swal.fire({
                icon: "warning",
                title: "Cancellation Reason Required",
                text: "Please provide a cancellation reason.",
                customClass: {
                    popup: "custom-swal-popup",
                    title: "custom-swal-title",
                    htmlContainer: "custom-swal-text",
                },
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
                cancellation_reason: reason,
            },
            success: function (response) {
                Swal.fire({
                    icon: "success",
                    title: "Commission cancelled successfully. Reloading...",
                    customClass: {
                        popup: "custom-swal-popup",
                        title: "custom-swal-title",
                        htmlContainer: "custom-swal-text",
                    },
                });
                setTimeout(() => location.reload(), 1000);
            },
            error: function (xhr, status, error) {
                Swal.fire({
                    icon: "error",
                    title: "Cancellation Failed",
                    text: "An error occurred while cancelling the commission.",
                    customClass: {
                        popup: "custom-swal-popup",
                        title: "custom-swal-title",
                        htmlContainer: "custom-swal-text",
                    },
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
