/**
 * Commission Actions Management
 * Handles all commission status updates and actions
 */

$(document).ready(function () {
    // Get commission ID from the page
    const commissionId = $("#commission-id").val();

    // Initialize modals and event listeners
    initializeModals();
});

/**
 * Update commission status
 */
function updateCommissionStatus(newStatus) {
    if (!confirm(`Are you sure you want to change the status to "${getStatusLabel(newStatus)}"?`)) {
        return;
    }

    $.ajax({
        url: `/artist/commission/${$("#commission-id").val()}/status`,
        type: "POST",
        data: {
            status: newStatus,
            _token: $('meta[name="csrf-token"]').attr("content"),
        },
        success: function (response) {
            if (response.success) {
                showNotification("Status updated successfully!", "success");
                setTimeout(() => location.reload(), 1500);
            } else {
                showNotification(
                    response.message || "Failed to update status",
                    "error"
                );
            }
        },
        error: function (xhr) {
            console.error("Error:", xhr);
            showNotification("Error updating status. Please try again.", "error");
        },
    });
}

/**
 * Reject commission with reason
 */
function rejectCommission() {
    const reason = prompt("Please enter the reason for rejection:");
    if (!reason) return;

    $.ajax({
        url: `/artist/commission/${$("#commission-id").val()}/reject`,
        type: "POST",
        data: {
            reason: reason,
            _token: $('meta[name="csrf-token"]').attr("content"),
        },
        success: function (response) {
            if (response.success) {
                showNotification("Commission rejected successfully", "success");
                setTimeout(() => (window.location.href = "/artist/commisions"), 1500);
            } else {
                showNotification(
                    response.message || "Failed to reject commission",
                    "error"
                );
            }
        },
        error: function (xhr) {
            console.error("Error:", xhr);
            showNotification(
                "Error rejecting commission. Please try again.",
                "error"
            );
        },
    });
}

/**
 * Cancel commission with reason
 */
function cancelCommission() {
    const reason = prompt("Please enter the reason for cancellation:");
    if (!reason) return;

    if (!confirm("Are you sure you want to cancel this commission? This action cannot be undone.")) {
        return;
    }

    $.ajax({
        url: `/artist/commission/${$("#commission-id").val()}/cancel`,
        type: "POST",
        data: {
            reason: reason,
            _token: $('meta[name="csrf-token"]').attr("content"),
        },
        success: function (response) {
            if (response.success) {
                showNotification("Commission cancelled successfully", "success");
                setTimeout(() => location.reload(), 1500);
            } else {
                showNotification(
                    response.message || "Failed to cancel commission",
                    "error"
                );
            }
        },
        error: function (xhr) {
            console.error("Error:", xhr);
            showNotification(
                "Error cancelling commission. Please try again.",
                "error"
            );
        },
    });
}

/**
 * Open upload modal
 */
function openUploadModal(stage) {
    $("#upload-type").val(stage);
    
    // Update modal title based on stage
    const titles = {
        'sketch': 'Upload Sketch Progress',
        'coloring': 'Upload Coloring Progress',
        'final': 'Upload Final Artwork',
        'revision': 'Upload Revised Work'
    };
    $("#upload-modal h3").text(titles[stage] || 'Upload Progress Image');
    
    $("#upload-modal").removeClass("hidden");
    $("#upload-modal").addClass("flex");
}

/**
 * Close upload modal
 */
function closeUploadModal() {
    $("#upload-modal").removeClass("flex");
    $("#upload-modal").addClass("hidden");
    $("#upload-form")[0].reset();
}

/**
 * Submit upload form
 */
function submitUpload() {
    const formData = new FormData($("#upload-form")[0]);
    formData.append("_token", $('meta[name="csrf-token"]').attr("content"));
    formData.append("commission_id", $("#commission-id").val());

    $.ajax({
        url: `/artist/commission/${$("#commission-id").val()}/upload`,
        type: "POST",
        data: formData,
        processData: false,
        contentType: false,
        beforeSend: function() {
            // Disable submit button and show loading
            $("#submit-upload-btn").prop("disabled", true).html('<i class="fas fa-spinner fa-spin mr-2"></i>Uploading...');
        },
        success: function (response) {
            if (response.success) {
                showNotification("Image uploaded successfully!", "success");
                closeUploadModal();
                setTimeout(() => location.reload(), 1500);
            } else {
                showNotification(
                    response.message || "Failed to upload image",
                    "error"
                );
                $("#submit-upload-btn").prop("disabled", false).html('<i class="fas fa-upload mr-2"></i>Upload');
            }
        },
        error: function (xhr) {
            console.error("Error:", xhr);
            const message = xhr.responseJSON?.message || "Error uploading image. Please try again.";
            showNotification(message, "error");
            $("#submit-upload-btn").prop("disabled", false).html('<i class="fas fa-upload mr-2"></i>Upload');
        },
    });
}

/**
 * Submit work for review
 */
function submitForReview(type) {
    const message =
        type === "sketch"
            ? "Submit sketch for client review?"
            : type === "revision"
            ? "Resubmit revised work for review?"
            : "Submit final work for client approval?";

    if (!confirm(message)) return;

    updateCommissionStatus("review");
}

/**
 * Update payment status
 */
function updatePaymentStatus(status) {
    if (!confirm(`Mark this commission as ${status.toUpperCase()}?`)) return;

    $.ajax({
        url: `/artist/commission/${$("#commission-id").val()}/payment`,
        type: "POST",
        data: {
            payment_status: status,
            _token: $('meta[name="csrf-token"]').attr("content"),
        },
        success: function (response) {
            if (response.success) {
                showNotification("Payment status updated!", "success");
                setTimeout(() => location.reload(), 1500);
            } else {
                showNotification(
                    response.message || "Failed to update payment status",
                    "error"
                );
            }
        },
        error: function (xhr) {
            console.error("Error:", xhr);
            showNotification(
                "Error updating payment status. Please try again.",
                "error"
            );
        },
    });
}

/**
 * Download all commission files
 */
function downloadFiles() {
    window.location.href = `/artist/commission/${$(
        "#commission-id"
    ).val()}/download`;
}

/**
 * Archive commission
 */
function archiveCommission() {
    if (
        !confirm(
            "Are you sure you want to archive this commission? It will be moved to archived commissions."
        )
    )
        return;

    $.ajax({
        url: `/artist/commission/${$("#commission-id").val()}/archive`,
        type: "POST",
        data: {
            _token: $('meta[name="csrf-token"]').attr("content"),
        },
        success: function (response) {
            if (response.success) {
                showNotification("Commission archived successfully", "success");
                setTimeout(() => (window.location.href = "/artist/commisions"), 1500);
            } else {
                showNotification(
                    response.message || "Failed to archive commission",
                    "error"
                );
            }
        },
        error: function (xhr) {
            console.error("Error:", xhr);
            showNotification(
                "Error archiving commission. Please try again.",
                "error"
            );
        },
    });
}

/**
 * View cancellation details
 */
function viewCancellationDetails() {
    $.ajax({
        url: `/artist/commission/${$("#commission-id").val()}/cancellation`,
        type: "GET",
        success: function (response) {
            if (response.success) {
                alert(
                    `Cancellation Details:\n\nReason: ${response.data.reason}\nDate: ${response.data.cancelled_at}\nCancelled by: ${response.data.cancelled_by}`
                );
            }
        },
        error: function (xhr) {
            console.error("Error:", xhr);
            showNotification(
                "Error loading cancellation details.",
                "error"
            );
        },
    });
}

/**
 * Open contact client modal
 */
function openContactModal() {
    $("#contact-modal").removeClass("hidden");
    $("#contact-modal").addClass("flex");
}

/**
 * Close contact modal
 */
function closeContactModal() {
    $("#contact-modal").removeClass("flex");
    $("#contact-modal").addClass("hidden");
}

/**
 * Initialize modals
 */
function initializeModals() {
    // Close modals when clicking outside
    $(document).on("click", ".modal-overlay", function (e) {
        if (e.target === this) {
            closeUploadModal();
            closeContactModal();
        }
    });

    // Close on ESC key
    $(document).on("keydown", function (e) {
        if (e.key === "Escape") {
            closeUploadModal();
            closeContactModal();
        }
    });
}

/**
 * Show notification
 */
function showNotification(message, type = "info") {
    const bgColor =
        type === "success"
            ? "bg-green-500"
            : type === "error"
            ? "bg-red-500"
            : type === "warning"
            ? "bg-amber-500"
            : "bg-blue-500";

    const notification = $(`
        <div class="fixed top-4 right-4 ${bgColor} text-white px-6 py-3 rounded-lg shadow-lg z-50 animate-slide-in">
            <div class="flex items-center gap-2">
                <i class="fas fa-${
                    type === "success"
                        ? "check-circle"
                        : type === "error"
                        ? "exclamation-circle"
                        : "info-circle"
                }"></i>
                <span>${message}</span>
            </div>
        </div>
    `);

    $("body").append(notification);

    setTimeout(() => {
        notification.fadeOut(300, function () {
            $(this).remove();
        });
    }, 3000);
}

/**
 * Get status label
 */
function getStatusLabel(status) {
    const labels = {
        pending: "Pending",
        accepted: "Accepted",
        in_progress_sketch: "In Progress (Sketching)",
        in_progress_coloring: "In Progress (Coloring)",
        review: "In Review",
        revision: "Revision",
        completed: "Completed",
        cancelled: "Cancelled",
    };
    return labels[status] || status;
}

// Add CSS animation
const style = document.createElement("style");
style.textContent = `
    @keyframes slide-in {
        from {
            transform: translateX(100%);
            opacity: 0;
        }
        to {
            transform: translateX(0);
            opacity: 1;
        }
    }
    .animate-slide-in {
        animation: slide-in 0.3s ease-out;
    }
`;
document.head.appendChild(style);
