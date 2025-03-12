<?php
include 'header.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoice Details</title>
    <!-- <link rel="stylesheet" href="wi.css"> -->
    <link rel="icon" href="../User/dp56vcf7.png" type="image/png">

    <!-- <script src="invoice.js" defer></script> -->
</head>
<style>
    .invoice-container {
        max-width: 800px;
        margin: 40px auto;
        padding: 30px;
        background: rgba(255, 255, 255, 0.1);
        backdrop-filter: blur(8px);
        -webkit-backdrop-filter: blur(8px);
        border-radius: 10px;
        border: 1px solid rgba(255, 255, 255, 0.2);
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        color: #ecf0f1;
    }

    .invoice-header {
        text-align: center;
        margin-bottom: 30px;
        padding-bottom: 20px;
        border-bottom: 2px solid rgba(255, 255, 255, 0.1);
    }

    .invoice-header h1 {
        color: #1abc9c;
        font-size: 28px;
        margin-bottom: 10px;
    }

    .invoice-details {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 20px;
        margin-bottom: 30px;
    }

    .detail-item {
        padding: 10px;
        background: rgba(44, 62, 80, 0.3);
        border-radius: 6px;
        transition: transform 0.3s ease;
    }

    .detail-item:hover {
        transform: translateY(-2px);
    }

    .detail-item strong {
        color: #1abc9c;
        display: block;
        margin-bottom: 5px;
    }

    .product-list {
        list-style: none;
        padding: 0;
        margin: 20px 0;
    }

    .product-item {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 15px;
        margin-bottom: 10px;
        background: rgba(44, 62, 80, 0.3);
        border-radius: 6px;
        transition: all 0.3s ease;
    }

    .product-item:hover {
        transform: translateX(5px);
        background: rgba(44, 62, 80, 0.5);
    }

    .total-amount {
        text-align: right;
        font-size: 20px;
        margin: 20px 0;
        padding: 20px;
        background: rgba(26, 188, 156, 0.2);
        border-radius: 6px;
    }

    .back-btn {
        background: #2c3e50;
        color: white;
        border: none;
        padding: 12px 24px;
        border-radius: 6px;
        cursor: pointer;
        font-size: 16px;
        transition: all 0.3s ease;
        display: flex;
        align-items: center;
        gap: 10px;
        margin-top: 20px;
    }

    .back-btn:hover {
        background: #34495e;
        transform: translateY(-2px);
    }

    @media (max-width: 768px) {
        .invoice-container {
            margin: 20px;
            padding: 20px;
        }

        .invoice-details {
            grid-template-columns: 1fr;
        }
    }
</style>
<style>
    .invoice-container {
        // ...existing code...
        background: rgba(20, 30, 48, 0.7);
        border: 1px solid rgba(100, 181, 246, 0.2);
        color: #e0e0e0;
    }

    .invoice-header {
        // ...existing code...
        border-bottom: 2px solid rgba(100, 181, 246, 0.2);
    }

    .invoice-header h1 {
        color: #64B5F6;
        text-shadow: 0 0 10px rgba(100, 181, 246, 0.3);
    }

    .detail-item {
        background: rgba(25, 35, 55, 0.6);
        border: 1px solid rgba(100, 181, 246, 0.1);
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.2);
    }

    .detail-item strong {
        color: #64B5F6;
    }

    .product-item {
        background: rgba(25, 35, 55, 0.6);
        border: 1px solid rgba(100, 181, 246, 0.1);
    }

    .product-item:hover {
        background: rgba(30, 40, 60, 0.8);
        border: 1px solid rgba(100, 181, 246, 0.3);
    }

    .total-amount {
        background: rgba(100, 181, 246, 0.1);
        border: 1px solid rgba(100, 181, 246, 0.2);
    }

    .back-btn {
        background: linear-gradient(135deg, #1976D2, #2196F3);
        border: 1px solid rgba(100, 181, 246, 0.3);
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.2);
    }

    .back-btn:hover {
        background: linear-gradient(135deg, #1E88E5, #42A5F5);
        box-shadow: 0 6px 12px rgba(33, 150, 243, 0.3);
    }

    /* Add subtle glow effects */
    .detail-item:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 12px rgba(100, 181, 246, 0.2);
        border: 1px solid rgba(100, 181, 246, 0.3);
    }

    /* Add glass morphism effect */
    .invoice-container, .detail-item, .product-item {
        backdrop-filter: blur(10px);
        -webkit-backdrop-filter: blur(10px);
    }
</style>
<body>

        <div class="invoice-container">
        <div class="invoice-header">
            <h1>Invoice Details</h1>
            <h2>Invoice #<span id="invoice-id"></span></h2>
        </div>
    
        <div class="invoice-details">
            <div class="detail-item">
                <strong>Customer Name</strong>
                <span id="customer-name"></span>
            </div>
            
            <div class="detail-item">
                <strong>Status</strong>
                <span id="status"></span>
            </div>
            
            <div class="detail-item">
                <strong>Address</strong>
                <span id="address"></span>
            </div>
            
            <div class="detail-item">
                <strong>Date</strong>
                <span id="purchase-date"></span>
            </div>
        </div>
    
        <h3>Products</h3>
        <ul class="product-list" id="product-list">
            <!-- Products will be listed here -->
        </ul>
    
        <div class="total-amount">
            <strong>Total Amount:</strong>
            <span id="total-amount"></span> VND
        </div>
    
        <button class="back-btn" id="back-btn">
            <i class="fa-solid fa-arrow-left"></i>
            Back to Orders
        </button>
    </div>



</body>
<script>
document.getElementById('back-btn').addEventListener('click', function() {
    window.location.href = 'manage-orders.php';
});

// Add fade-in animation on load
document.addEventListener('DOMContentLoaded', function() {
    const container = document.querySelector('.invoice-container');
    container.style.opacity = '0';
    container.style.transform = 'translateY(20px)';
    
    setTimeout(() => {
        container.style.transition = 'all 0.5s ease';
        container.style.opacity = '1';
        container.style.transform = 'translateY(0)';
    }, 100);
});
</script>
</html>
<?php
include 'footer.php';
?>