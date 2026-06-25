document.addEventListener("DOMContentLoaded", function () {
    // Handle Reservation Form Submission
    document.getElementById("reservationForm").addEventListener("submit", function (event) {
        event.preventDefault();
        const reservationID = document.getElementById("reservationID").value;

        fetchReservationDetails(reservationID);
    });

    // Fetch Reservation Details from the Server
    function fetchReservationDetails(reservationID) {
        fetch(`fetch_reservation_details.php?reservation_id=${reservationID}`)
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    displayReservationDetails(data.reservation);
                    checkForDiscount(data.reservation);
                } else {
                    alert("Error: " + data.message);
                }
            })
            .catch(error => console.error("Fetch error:", error));
    }

    // Display Reservation Details
    function displayReservationDetails(reservation) {
        document.getElementById("resID").innerText = reservation.reservation_id;
        document.getElementById("name").innerText = reservation.name;
        document.getElementById("phone").innerText = reservation.phone;
        document.getElementById("nationality").innerText = reservation.nationality;
        document.getElementById("checkinDate").innerText = reservation.checkin_date;
        document.getElementById("checkoutDate").innerText = reservation.checkout_date;
        document.getElementById("adults").innerText = reservation.adults;
        document.getElementById("children").innerText = reservation.children;
        document.getElementById("roomType").innerText = reservation.room_type;
        document.getElementById("beddingType").innerText = reservation.bedding_type;
        document.getElementById("initialAmount").innerText = reservation.initial_amount;
        document.getElementById("totalAmount").innerText = reservation.total_amount;
        document.getElementById("paymentMethod").innerText = reservation.payment_method;

        // Show the Reservation Details Section
        document.getElementById("reservationDetails").style.display = "block";
    }

    // Check for Discount Eligibility
    function checkForDiscount(reservation) {
        const stayDuration = calculateStayDuration(reservation.checkin_date, reservation.checkout_date);
        const totalAmount = reservation.total_amount;

        if (stayDuration > 7 || totalAmount > 100000) {
            document.getElementById("spinWheel").style.display = "block";
        }
    }

    // Calculate Stay Duration in Days
    function calculateStayDuration(checkinDate, checkoutDate) {
        const checkin = new Date(checkinDate);
        const checkout = new Date(checkoutDate);
        const duration = (checkout - checkin) / (1000 * 3600 * 24);
        return duration;
    }

    // Handle Spin Wheel Action
    document.getElementById("spinButton").addEventListener("click", function () {
        const discount = Math.floor(Math.random() * 16); // Random discount between 0% and 15%
        document.getElementById("discountMessage").innerText = `You got a ${discount}% discount!`;
    });

    // Handle Generate Invoice
    document.getElementById("generateInvoice").addEventListener("click", function () {
        const reservationID = document.getElementById("resID").innerText;
        const invoiceData = {
            reservation_id: reservationID,
            name: document.getElementById("name").innerText,
            total_amount: document.getElementById("totalAmount").innerText,
            payment_method: document.getElementById("paymentMethod").innerText,
            discount: document.getElementById("discountMessage").innerText
        };

        // Send invoice data to the server
        fetch('generate_invoice.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify(invoiceData),
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert("Invoice generated successfully!");
            } else {
                alert("Error generating invoice: " + data.message);
            }
        })
        .catch(error => console.error('Error:', error));
    });
});
