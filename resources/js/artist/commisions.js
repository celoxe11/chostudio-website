$(document).ready(function () {
    let currentPage = 1;
    let currentFilters = {
        search: "",
        status: "",
        payment_status: "",
        category: "",
        per_page: 10,
    };

    // Load commissions on page load
    loadCommissions();

    // Search input with debounce
    let searchTimeout;
    $("#search-input").on("input", function () {
        clearTimeout(searchTimeout);
        searchTimeout = setTimeout(function () {
            currentFilters.search = $("#search-input").val();
            currentPage = 1;
            loadCommissions();
        }, 500);
    });

    // Filter changes
    $("#status-filter, #payment-filter, #category-filter").on(
        "change",
        function () {
            currentFilters.status = $("#status-filter").val();
            currentFilters.payment_status = $("#payment-filter").val();
            currentFilters.category = $("#category-filter").val();
            currentPage = 1;
            loadCommissions();
        }
    );

    // Per page change
    $("#per-page").on("change", function () {
        currentFilters.per_page = $(this).val();
        currentPage = 1;
        loadCommissions();
    });

    // Clear filters
    $("#clear-filters").on("click", function () {
        $("#search-input").val("");
        $("#status-filter").val("");
        $("#payment-filter").val("");
        $("#category-filter").val("");
        $("#per-page").val("10");
        currentFilters = {
            search: "",
            status: "",
            payment_status: "",
            category: "",
            per_page: 10,
        };
        currentPage = 1;
        loadCommissions();
    });

    // Pagination buttons
    $(document).on("click", "#pagerPrev", function () {
        if (currentPage > 1) {
            currentPage--;
            loadCommissions();
        }
    });

    $(document).on("click", "#pagerNext", function () {
        const lastPage = parseInt($("#pagerNext").data("last-page"));
        if (currentPage < lastPage) {
            currentPage++;
            loadCommissions();
        }
    });

    $(document).on("click", ".page-number", function () {
        currentPage = parseInt($(this).data("page"));
        loadCommissions();
    });

    function loadCommissions() {
        const params = {
            page: currentPage,
            ...currentFilters,
        };

        $.ajax({
            url: "/artist/getCommisions",
            type: "GET",
            data: params,
            dataType: "json",
            beforeSend: function () {
                $("#commissions-tbody").html(`
                            <tr>
                                <td colspan="7" class="p-0 border-none align-top">
                                    <div class="min-h-[60vh] flex items-center justify-center bg-(--color-background)">
                                        <div class="text-lg max-md:p-1 text-stone-700">
                                            <i class="fas fa-spinner fa-spin mr-2"></i>Loading commissions...
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        `);
            },
            success: function (response) {
                if (response.success) {
                    renderCommissions(response.data);
                    renderPagination(response.pagination);
                    updateStatusCounts(response.status_counts);
                }
            },
            error: function (xhr) {
                console.error("Error loading commissions:", xhr);
                $("#commissions-tbody").html(`
                            <tr>
                                <td colspan="7" class="p-0 border-none align-top">
                                    <div class="min-h-[60vh] flex items-center justify-center bg-(--color-background)">
                                        <div class="text-lg max-md:p-1 text-red-600">
                                            <i class="fas fa-exclamation-circle mr-2"></i>Error loading commissions. Please try again.
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        `);
            },
        });
    }

    function renderCommissions(commissions) {
        const tbody = $("#commissions-tbody");
        tbody.empty();

        if (commissions.length === 0) {
            tbody.html(`
                        <tr>
                            <td colspan="7" class="p-0 border-none align-top">
                                <div class="min-h-[48vh] flex items-center justify-center bg-(--color-background)">
                                    <div class="text-lg max-md:p-1 text-stone-700">No commissions found</div>
                                </div>
                            </td>
                        </tr>
                    `);
            return;
        }

        commissions.forEach(function (c) {
            const statusColor = getProgressStatusColor(c.progress_status);
            const statusText = getProgressStatusText(c.progress_status);
            const paymentColor = getPaymentStatusColor(c.payment_status);
            const paymentText = getPaymentStatusText(c.payment_status);

            const row = `
                        <tr class="bg-(--color-background)">
                            <td class="p-3 md:p-4 text-lg max-lg:text-base max-sm:text-sm max-md:p-1 border border-stone-900 align-top">
                                <div class="font-semibold">${
                                    c.member?.name || "N/A"
                                }</div>
                                <div class="text-sm text-gray-600">${
                                    c.member?.email || "N/A"
                                }</div>
                            </td>
                            <td class="p-3 md:p-4 text-lg max-lg:text-base max-sm:text-sm max-md:p-1 border border-stone-900 align-top">
                                ${c.category || "N/A"}
                            </td>
                            <td class="p-3 md:p-4 text-lg max-lg:text-base max-sm:text-sm max-md:p-1 border border-stone-900 hidden sm:table-cell align-top">
                                ${truncateText(c.description, 50) || "N/A"}
                            </td>
                            <td class="p-3 md:p-4 text-lg max-lg:text-base max-sm:text-sm max-md:p-1 border border-stone-900 hidden md:table-cell align-top">
                                Rp. ${Number(c.price || 0).toLocaleString(
                                    "id-ID"
                                )}
                            </td>
                            <td class="p-3 md:p-4 text-lg max-lg:text-base max-sm:text-sm max-md:p-1 border border-stone-900 hidden sm:table-cell align-top">
                                ${formatDate(c.deadline)}
                            </td>
                            <td class="p-3 md:p-4 text-lg max-lg:text-base max-sm:text-sm max-md:p-1 border border-stone-900 align-top">
                                <div class="flex flex-col text-lg max-lg:text-base max-sm:text-sm max-md:text-sm md:text-base sm:flex-row gap-2 items-center justify-center">
                                    <button disabled class="px-3 py-1 rounded-full text-white font-medium ${statusColor}">
                                        ${statusText}
                                    </button>
                                    <button disabled class="px-3 py-1 rounded-full text-white font-medium ${paymentColor}">
                                        ${paymentText}
                                    </button>
                                </div>
                            </td>
                            <td class="p-3 md:p-4 text-lg max-lg:text-base max-sm:text-sm max-md:text-sm border border-stone-900 align-top">
                                <div class="flex flex-col sm:flex-row items-center justify-center gap-2">
                                    <a href="{{ route("artist.commision_detail") }}"
                                        class="px-2 py-1 rounded-lg w-full sm:w-auto border-2 border-green-600 text-green-900 font-semibold shadow-md hover:shadow-lg hover:scale-105 hover:bg-green-600 transition-all duration-200"
                                        style="background-color: var(--status-success);">View</a>
                                    <a class="px-2 py-1 rounded-lg w-full sm:w-auto border-2 border-yellow-500 text-yellow-900 font-semibold shadow-md hover:shadow-lg hover:scale-105 hover:bg-yellow-500 transition-all duration-200"
                                        style="background-color: var(--status-warning);">Accept</a>
                                    <a class="px-2 py-1 rounded-lg w-full sm:w-auto border-2 border-red-600 text-red-900 font-semibold shadow-md hover:shadow-lg hover:scale-105 hover:bg-red-600 transition-all duration-200"
                                        style="background-color: var(--status-danger);">Decline</a>
                                </div>
                            </td>
                        </tr>
                    `;
            tbody.append(row);
        });
    }

    function renderPagination(pagination) {
        $("#pagerRange").text(`${pagination.from || 0}-${pagination.to || 0}`);
        $("#pagerTotal").text(pagination.total || 0);

        // Update buttons
        $("#pagerPrev").prop("disabled", pagination.current_page <= 1);
        $("#pagerNext")
            .prop("disabled", pagination.current_page >= pagination.last_page)
            .data("last-page", pagination.last_page);

        // Render page numbers
        const pagerNumbers = $("#pagerNumbers");
        pagerNumbers.empty();

        const maxPages = 5;
        let startPage = Math.max(
            1,
            pagination.current_page - Math.floor(maxPages / 2)
        );
        let endPage = Math.min(pagination.last_page, startPage + maxPages - 1);

        if (endPage - startPage < maxPages - 1) {
            startPage = Math.max(1, endPage - maxPages + 1);
        }

        for (let i = startPage; i <= endPage; i++) {
            const isActive = i === pagination.current_page;
            const pageBtn = `
                        <button class="page-number px-3 py-1 rounded border-2 border-stone-900 text-sm ${
                            isActive ? "bg-stone-900 text-white" : "bg-white"
                        }" 
                            data-page="${i}">
                            ${i}
                        </button>
                    `;
            pagerNumbers.append(pageBtn);
        }
    }

    function updateStatusCounts(counts) {
        $("#status-pending").text(`${counts.pending} Pending`);
        $("#status-in-progress").text(`${counts.in_progress} In Progress`);
        $("#status-revision").text(`${counts.revision} Revision`);
    }

    function getProgressStatusColor(status) {
        const statusColors = {
            pending: "bg-red-500", // Red - waiting for action
            accepted: "bg-blue-500", // Blue - accepted
            in_progress_sketch: "bg-purple-500", // Purple - working on sketch
            in_progress_coloring: "bg-purple-400", // Light purple - working on color
            review: "bg-amber-500", // Orange - under review
            revision: "bg-orange-500", // Dark orange - needs changes
            completed: "bg-green-500", // Green - done
            cancelled: "bg-gray-500", // Gray - cancelled
        };
        return statusColors[status] || "bg-gray-500";
    }

    function getProgressStatusText(status) {
        const statusTexts = {
            pending: "Pending",
            accepted: "Accepted",
            in_progress_sketch: "Sketching",
            in_progress_coloring: "Coloring",
            review: "In Review",
            revision: "Revision",
            completed: "Completed",
            cancelled: "Cancelled",
        };
        return statusTexts[status] || "Unknown";
    }

    function getPaymentStatusColor(status) {
        const paymentColors = {
            pending: "bg-red-500", // Red - not paid
            dp: "bg-amber-500", // Orange - down payment
            paid: "bg-green-500", // Green - fully paid
            refunded: "bg-gray-500", // Gray - refunded
        };
        return paymentColors[status] || "bg-gray-500";
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

    function getStatusColor(status) {
        const statusColors = {
            Pending: "var(--status-danger)",
            "In Progress (Sketch)": "var(--status-info)",
            "In Progress (Color)": "var(--status-info)",
            Revision: "var(--status-warning)",
            Completed: "var(--status-success)",
        };
        return statusColors[status] || "var(--status-neutral)";
    }

    function formatDate(dateString) {
        if (!dateString) return "N/A";
        const date = new Date(dateString);
        return date.toLocaleDateString("en-US", {
            year: "numeric",
            month: "short",
            day: "numeric",
        });
    }

    function truncateText(text, maxLength = 50) {
        if (!text) return "";
        if (text.length <= maxLength) return text;
        return text.substring(0, maxLength).trim() + "...";
    }
});
