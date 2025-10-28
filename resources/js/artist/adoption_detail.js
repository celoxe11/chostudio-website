function setOrderStatus(adoptionId, status) {
    $.ajax({
        url: `/artist/adoptions/status/${adoptionId}`,
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
                    "Updated Adoption Status to '" +
                    getOrderStatusText(status) +
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
                text: "An error occurred while updating the adoption status.",
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

$(document).ready(function () {
    // Toggle delivery method sections
    $('input[name="delivery_method"]').change(function () {
        if ($("#delivery_method_upload").is(":checked")) {
            $("#upload-section").removeClass("hidden");
            $("#link-section").addClass("hidden");
        } else {
            $("#upload-section").addClass("hidden");
            $("#link-section").removeClass("hidden");
        }
    });

    // Handle file input change
    $("#delivery_files").change(function () {
        const files = this.files;
        const fileNameDiv = $("#file-name");

        if (files.length > 0) {
            let fileNames = "";
            if (files.length === 1) {
                fileNames = files[0].name;
            } else {
                fileNames = files.length + " files selected";
            }

            fileNameDiv
                .text(fileNames)
                .removeClass("hidden")
                .hide()
                .slideDown(200);
        } else {
            fileNameDiv.slideUp(200, function () {
                $(this).addClass("hidden");
            });
        }
    });

    // Get adoptionId from button data attribute
    $("#confirm-order-btn").click(function () {
        const adoptionId = $(this).data("adoption-id");
        Swal.fire({
            title: "Are you sure?",
            text: "You are about to update the payment status to 'Confirmed'.",
            icon: "question",
            showCancelButton: true,
            confirmButtonText: "Yes, update it!",
            customClass: {
                popup: "custom-swal-popup",
                title: "custom-swal-title",
                htmlContainer: "custom-swal-text",
                confirmButton: "custom-swal-success-button",
                cancelButton: "custom-swal-cancel-button",
            },
        }).then((result) => {
            if (result.isConfirmed) {
                setOrderStatus(adoptionId, "confirmed");
            }
        });
    });

    $("#cancel-order-btn").click(function () {
        const adoptionId = $(this).data("adoption-id");
        Swal.fire({
            title: "Are you sure?",
            text: "You are about to update the payment status to 'Cancelled'.",
            icon: "question",
            showCancelButton: true,
            confirmButtonText: "Yes, update it!",
            customClass: {
                popup: "custom-swal-popup",
                title: "custom-swal-title",
                htmlContainer: "custom-swal-text",
                confirmButton: "custom-swal-danger-button",
                cancelButton: "custom-swal-cancel-button",
            },
        }).then((result) => {
            if (result.isConfirmed) {
                setOrderStatus(adoptionId, "cancelled");
            }
        });
    });

    $("#confirm-payment-btn").click(function () {
        // add a confirmation swal, if yes update the status to processing via ajax
        const adoptionId = $(this).data("adoption-id");

        Swal.fire({
            title: "Are you sure?",
            text: "You are about to confirm the payment. This will set the payment status to 'Paid'.",
            icon: "question",
            showCancelButton: true,
            customClass: {
                popup: "custom-swal-popup",
                title: "custom-swal-title",
                htmlContainer: "custom-swal-text",
                confirmButton: "custom-swal-success-button",
                cancelButton: "custom-swal-cancel-button",
            },
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: `/artist/adoptions/confirm_payment/${adoptionId}`,
                    type: "POST",
                    success: function (response) {
                        Swal.fire({
                            icon: "success",
                            title: "Success!",
                            text: "Payment confirmed. Reloading...",
                            customClass: {
                                popup: "custom-swal-popup",
                                title: "custom-swal-title",
                                htmlContainer: "custom-swal-text",
                                confirmButton: "custom-swal-success-button",
                                cancelButton: "custom-swal-cancel-button",
                            },
                        });
                        setTimeout(() => location.reload(), 1000);
                    },
                    error: function (xhr, status, error) {
                        Swal.fire({
                            icon: "error",
                            title: "Error!",
                            text: "An error occurred while confirming the payment.",
                            customClass: {
                                popup: "custom-swal-popup",
                                title: "custom-swal-title",
                                htmlContainer: "custom-swal-text",
                                confirmButton: "custom-swal-success-button",
                                cancelButton: "custom-swal-cancel-button",
                            },
                        });
                        console.error(
                            "Payment confirmation error:",
                            xhr.responseJSON || error
                        );
                    },
                });
            }
        });
    });

    $("#save-notes-btn").click(function () {
        const adoptionId = $(this).data("adoption-id");
        const notes = $("#delivery_notes").val();

        $.ajax({
            url: `/artist/adoptions/save_notes/${adoptionId}`,
            type: "POST",
            data: {
                notes: notes,
            },
            success: function (response) {
                Swal.fire({
                    icon: "success",
                    title: "Success!",
                    text: "Delivery notes saved successfully.",
                    customClass: {
                        popup: "custom-swal-popup",
                        title: "custom-swal-title",
                        htmlContainer: "custom-swal-text",
                    },
                });
            },
            error: function (xhr, status, error) {
                Swal.fire({
                    icon: "error",
                    title: "Error!",
                    text: "An error occurred while saving the delivery notes.",
                    customClass: {
                        popup: "custom-swal-popup",
                        title: "custom-swal-title",
                        htmlContainer: "custom-swal-text",
                    },
                });
                console.error("Save notes error:", xhr.responseJSON || error);
            },
        });
    });

    $("#send-delivery-email-btn").click(function () {
        // add a confirmation swal, if yes update the status to delivered via ajax
        const adoptionId = $(this).data("adoption-id");

        const formData = new FormData();
        if ($("#delivery_method_upload").is(":checked")) {
            formData.append("delivery_file", $("#delivery_files")[0].files[0]);
        } else {
            formData.append("delivery_link", $("#delivery_link").val());
        }

        Swal.fire({
            title: "Send Your Files To Buyer?",
            text: "You are about to send the delivery files to the buyer via email. Make sure you have uploaded the correct files or provided a download link.",
            icon: "question",
            showCancelButton: true,
            customClass: {
                popup: "custom-swal-popup",
                title: "custom-swal-title",
                htmlContainer: "custom-swal-text",
                confirmButton: "custom-swal-success-button",
                cancelButton: "custom-swal-cancel-button",
            },
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: `/artist/adoptions/deliver_file/${adoptionId}`,
                    type: "POST",
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function (response) {
                        Swal.fire({
                            icon: "success",
                            title: "Success!",
                            text: "Delivery email sent. Reloading...",
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
                            text: "An error occurred while sending the delivery email.",
                            customClass: {
                                popup: "custom-swal-popup",
                                title: "custom-swal-title",
                                htmlContainer: "custom-swal-text",
                            },
                        });
                    },
                });
            }
        });
    });

    $("#mark-complete-btn").click(function () {
        // add a confirmation swal, if yes update the status to completed via ajax
    });
});

function getOrderStatusColor(status) {
    const statusColors = {
        pending: "bg-red-600", // Red - waiting for artist confirmation
        confirmed: "bg-blue-500", // blue - confirmed by artist
        processing: "bg-amber-500", // Amber - preparing files
        delivered: "bg-purple-400", // Purple - files delivered
        completed: "bg-green-600", // Green - order completed
        cancelled: "bg-gray-500", // gray - cancelled
    };
    return statusColors[status] || "bg-gray-500";
}

function getOrderStatusText(status) {
    const statusTexts = {
        pending: "Pending",
        confirmed: "Confirmed",
        processing: "Processing",
        delivered: "Delivered",
        completed: "Completed",
        cancelled: "Cancelled",
    };
    return statusTexts[status] || "Unknown";
}

function getPaymentStatusColor(status) {
    const paymentColors = {
        unpaid: "bg-red-600", // Red - not paid
        paid: "bg-green-600", // Green - paid
        refunded: "bg-blue-600", // Cyan - refunded
        failed: "bg-gray-600", // gray - failed
    };
    return paymentColors[status] || "bg-gray-400";
}

function getPaymentStatusText(status) {
    const paymentTexts = {
        unpaid: "Unpaid",
        paid: "Paid",
        refunded: "Refunded",
        failed: "Failed",
    };
    return paymentTexts[status] || "Unknown";
}
