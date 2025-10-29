function getHistoryData() {
    // FIX 1: Use the correct container ID defined in the HTML
    const container = $("#historyContainer");

    $.ajax({
        url: "/member/getHistory",
        method: "GET",
        dataType: "json",

        beforeSend: function () {
            // Display loading state in the correct container
            container.html(`
                        <div id="loading-message" class="col-span-full row-span-full text-center p-12">
                            <i class="fa-solid fa-spinner fa-spin mr-3 text-stone-600 text-3xl"></i>
                            <p class="text-xl text-stone-900 mt-2">Loading history data...</p>
                        </div>
                    `);
        },

        success: function (response) {
            // FIX 2: Implement robust data check aligned with PHP output (success flag and data array)
            const historyData =
                response && response.success && Array.isArray(response.data)
                    ? response.data
                    : [];

            if (historyData.length === 0) {
                // Display no results message if data is empty or invalid
                container.html(`
                            <div class="p-12 text-center text-lg text-stone-500">
                                <i class="fa-solid fa-box-open mr-2 text-2xl"></i> No history found yet.
                            </div>
                        `);
                return;
            }

            // If data is valid and non-empty, render the grid and cards
            container.html(
                // Adjusted grid classes slightly for responsiveness and padding (p-6)
                `<div id="history-grid" class="grid p-6 gap-6 grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 2xl:grid-cols-5"></div>`
            );

            historyData.forEach((item) => {
                const colors = getCardColors(item);
                const status =
                    item.type === "Commission"
                        ? item.progress_status
                        : item.order_status;
                const id =
                    item.type == "Commission"
                        ? item.commission_id
                        : item.adoption_id;

                // NOTE: Using inline styles for dynamic colors as per previous design choice.
                // Item.title is used as the sub-heading, falling back to 'Artwork for You'.
                $("#history-grid").append(
                    `
                            <a href="/member/history/${(
                                item.type || ""
                            ).toLowerCase()}/${id}" 
                                class="flex flex-col justify-center items-center p-4 rounded-xl hover:scale-[1.02] hover:shadow-xl transition-all duration-300 transform border-2"
                                style="background-color: ${
                                    colors.bgColor
                                }; border-color: ${colors.borderColor};">
                                
                                <div class="text-center mb-2">
                                    <h2 class="text-xl text-stone-800 font-bold">${
                                        item.type
                                    }</h2>
                                    <p class="text-sm" style="color: ${
                                        colors.textColor
                                    }; opacity: 0.9;">${
                        item.title ?? "Artwork for You"
                    }</p>
                                </div>
                                
                                <div class="border-t border-[#ad99d0] text-center space-y-1 pt-2 mb-3 w-full">
                                    <p class="text-sm text-stone-700"><i class="fa-solid fa-calendar mr-2"></i> ${formatDate(
                                        item.created_at
                                    )}</p>
                                    <p class="text-sm text-stone-700"><i class="fa-solid fa-money-bill-wave mr-2"></i> ${formatPrice(
                                        item.price
                                    )}</p>
                                </div>
                                
                                <button class="rounded-full py-1 px-3 font-bold text-sm capitalize mb-3 text-white shadow-md ${
                                    getPrimaryStatusInfo(item.type, status)
                                        .colorClass
                                }">
                                    ${
                                        getPrimaryStatusInfo(item.type, status)
                                            .text
                                    }
                                </button>
                                
                                <button class="rounded-full py-1 px-3 font-bold text-sm capitalize text-white shadow-md ${
                                    getPaymentInfo(
                                        item.type,
                                        item.payment_status
                                    ).colorClass
                                }">
                                    ${
                                        getPaymentInfo(
                                            item.type,
                                            item.payment_status
                                        ).text
                                    }
                                </button>
                            </a>
                            `
                );
            });
        },

        error: function (xhr, status, error) {
            // Display error message for network/server issues
            console.error("Error fetching history data:", error);
            container.html(`
                        <div class="p-12 text-center text-lg text-red-600">
                            <i class="fa-solid fa-xmark-circle mr-2 text-3xl"></i>
                            <p class="mt-2">Failed to load history data. Please check your network or try again later.</p>
                            <p class="text-sm text-red-400">Error: ${
                                error || "Unknown Error"
                            }</p>
                        </div>
                    `);
        },
    });
}

$(document).ready(function () {
    getHistoryData();

    $("#filterSelect").on("change", function () {
        const selectedType = $(this).val();
        $("#commissionStatusContainer").toggleClass(
            "hidden",
            selectedType !== "commission"
        );
        $("#adoptionStatusContainer").toggleClass(
            "hidden",
            selectedType !== "adoption"
        );
    });
});

function getCardColors(item) {
    let bgColor = item.type === "Adoption" ? "#ffd5bf" : "#d4c7f0";
    let borderColor = item.type === "Adoption" ? "#ff7f3f" : "#ad99d0";
    let textColor = item.type === "Adoption" ? "#b34700" : "#7b61ff";
    return { bgColor, borderColor, textColor };
}

function sentenceCase(word) {
    // make the word sentence case
    return word
        ? word.charAt(0).toUpperCase() + word.slice(1).toLowerCase()
        : "N/A";
}

function getPrimaryStatusInfo(type, status) {
    const typeLower = type.toLowerCase();

    if (typeLower === "commission") {
        // Commission Progress Status
        switch (status) {
            case "pending":
                return { text: "Pending", colorClass: "bg-yellow-500" };
            case "accepted":
                return { text: "Accepted", colorClass: "bg-blue-500" };
            case "declined":
                return { text: "Declined", colorClass: "bg-red-600" };
            case "in_progress_sketch":
                return { text: "Sketching", colorClass: "bg-purple-500" };
            case "in_progress_coloring":
                return { text: "Coloring", colorClass: "bg-pink-500" };
            case "review":
                return { text: "In Review", colorClass: "bg-cyan-500" };
            case "revision":
                return { text: "Revision", colorClass: "bg-orange-500" };
            case "completed":
                return { text: "Completed", colorClass: "bg-green-500" };
            case "cancelled":
                return { text: "Cancelled", colorClass: "bg-gray-500" };
            default:
                return { text: "Unknown", colorClass: "bg-gray-500" };
        }
    } else if (typeLower === "adoption") {
        // Adoption Order Status
        switch (status) {
            case "pending":
                return { text: "Pending", colorClass: "bg-red-600" };
            case "confirmed":
                return { text: "Confirmed", colorClass: "bg-blue-500" };
            case "processing":
                return { text: "Processing", colorClass: "bg-amber-500" };
            case "delivered":
                return { text: "Delivered", colorClass: "bg-purple-400" };
            case "completed":
                return { text: "Completed", colorClass: "bg-green-600" };
            case "cancelled":
                return { text: "Cancelled", colorClass: "bg-gray-500" };
            default:
                return { text: "Unknown", colorClass: "bg-gray-500" };
        }
    }

    return { text: "N/A", colorClass: "bg-gray-400" };
}

/**
 * Combines Payment Status logic for Commission and Adoption.
 * @param {string} type - 'commission' or 'adoption'.
 * @param {string} status - The raw payment status key (e.g., 'dp', 'unpaid', 'paid').
 * @returns {{text: string, colorClass: string}} Payment status text and Tailwind color class.
 */
function getPaymentInfo(type, status) {
    const typeLower = type.toLowerCase();
    const statusClean = status.toLowerCase().replace(/ /g, "_");

    if (typeLower === "commission") {
        // Commission Payment Status (pending/dp/paid/refunded)
        switch (statusClean) {
            case "pending":
                return { text: "Unpaid", colorClass: "bg-red-500" };
            case "dp":
                return { text: "DP", colorClass: "bg-amber-500" };
            case "paid":
                return { text: "Paid", colorClass: "bg-green-500" };
            case "refunded":
                return { text: "Refunded", colorClass: "bg-gray-500" };
            default:
                return { text: "Unknown", colorClass: "bg-gray-500" };
        }
    } else if (typeLower === "adoption") {
        // Adoption Payment Status (unpaid/paid/refunded/failed)
        switch (statusClean) {
            case "unpaid":
                return { text: "Unpaid", colorClass: "bg-red-600" };
            case "paid":
                return { text: "Paid", colorClass: "bg-green-600" };
            case "refunded":
                return { text: "Refunded", colorClass: "bg-blue-600" };
            case "failed":
                return { text: "Failed", colorClass: "bg-gray-600" };
            default:
                return { text: "Unknown", colorClass: "bg-gray-400" };
        }
    }

    return { text: "N/A", colorClass: "bg-gray-400" };
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

function formatPrice(price) {
    if (price == null) return "N/A";
    // Check for potential price property differences between models
    const finalPrice = price.final_price ?? price.price ?? price;
    return "Rp. " + Number(finalPrice).toLocaleString("id-ID");
}
