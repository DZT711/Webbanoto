<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoice Details</title>
    <link rel="stylesheet" href="wi.css">
    <link rel="icon" href="../User/dp56vcf7.png" type="image/png">

    <script src="invoice.js" defer></script>
</head>
<body>

    <header>
        <h1>Invoice Details</h1>
    </header>

    <section class="invoice">
        <h2>Invoice #<span id="invoice-id"></span></h2>
        <p><strong>Name:</strong> <span id="customer-name"></span></p>
        <p><strong>Status:</strong> <span id="status"></span></p>
        <p><strong>Address:</strong> <span id="address"></span></p>
        <h3>Products</h3>
        <ul id="product-list">
            <!-- Product items will be listed here -->
        </ul>
        <p><strong>Total Amount:</strong> <span id="total-amount"></span> VND</p>
        <p><strong>Date:</strong> <span id="purchase-date"></span></p>

        <!-- Back Button -->
        <button id="back-btn">Trở về</button>
    </section>

    <footer>
        <p>© 2024 Auto Car. All rights reserved.</p>
    </footer>

</body>
</html>
