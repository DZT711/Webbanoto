<?php
include 'header.php';


// Add this PHP function at the top of the file
function buildFilterQuery($filters)
{
    $base_query = "SELECT o.*, u.username, u.full_name, u.phone_num, u.email 
                   FROM orders o 
                   JOIN users_acc u ON o.user_id = u.id";
    $where_clauses = [];
    $params = [];
    $types = "";

    // Date range filter
    if (!empty($filters['start_date'])) {
        $where_clauses[] = "o.order_date >= ?";
        $params[] = $filters['start_date'];
        $types .= "s";
    }
    if (!empty($filters['end_date'])) {
        $where_clauses[] = "o.order_date <= ?";
        $params[] = $filters['end_date'] . " 23:59:59";
        $types .= "s";
    }

    // Status filter
    if (!empty($filters['status'])) {
        $where_clauses[] = "o.order_status = ?";
        $params[] = $filters['status'];
        $types .= "s";
    }

    // Location sorting
    $order_by = !empty($filters['sort_location']) ?
        "o.shipping_address ASC" :
        "o.order_date DESC";

    // Combine where clauses
    $query = $base_query;
    if (!empty($where_clauses)) {
        $query .= " WHERE " . implode(" AND ", $where_clauses);
    }
    $query .= " ORDER BY " . $order_by;

    return ['query' => $query, 'params' => $params, 'types' => $types];
}
// Process status update first
if (isset($_POST['update_status']) && isset($_POST['order_id'])) {
    try {
        $order_id = intval($_POST['order_id']);
        $status = mysqli_real_escape_string($connect, $_POST['order_status']);

        $update_query = "UPDATE orders SET order_status = ? WHERE order_id = ?";
        $stmt = mysqli_prepare($connect, $update_query);
        mysqli_stmt_bind_param($stmt, "si", $status, $order_id);

        if (mysqli_stmt_execute($stmt)) {
            $_SESSION['notification'] = [
                'message' => 'Status updated successfully',
                'type' => 'success'
            ];
        } else {
            throw new Exception("Failed to update status");
        }

    } catch (Exception $e) {
        $_SESSION['notification'] = [
            'message' => $e->getMessage(),
            'type' => 'error'
        ];
    }
    // Use JavaScript for redirect instead of header()
    echo "<script>window.location.href = 'manage-orders.php';</script>";
    exit();
}

// Replace the existing orders query with this filtering logic
$where_clauses = [];
$params = [];
$types = "";

// Date range filter
if (!empty($_GET['start_date'])) {
    $where_clauses[] = "o.order_date >= ?";
    $params[] = $_GET['start_date'];
    $types .= "s";
}
if (!empty($_GET['end_date'])) {
    $where_clauses[] = "o.order_date <= ?";
    $params[] = $_GET['end_date'] . " 23:59:59";
    $types .= "s";
}

// Status filter
if (!empty($_GET['status']) && $_GET['status'] !== 'all') {
    $where_clauses[] = "o.order_status = ?";
    $params[] = $_GET['status'];
    $types .= "s";
}

// Base query
$query = "SELECT o.*, u.username, u.full_name, u.phone_num, u.email 
          FROM orders o 
          JOIN users_acc u ON o.user_id = u.id";

// Add where clauses if any
if (!empty($where_clauses)) {
    $query .= " WHERE " . implode(" AND ", $where_clauses);
}

// Add sorting
$sort = $_GET['sort'] ?? 'date_desc';
switch ($sort) {
    case 'location':
        $query .= " ORDER BY o.shipping_address ASC";
        break;
    case 'date_asc':
        $query .= " ORDER BY o.order_date ASC";
        break;
    default:
        $query .= " ORDER BY o.order_date DESC";
}

// Prepare and execute query
$stmt = mysqli_prepare($connect, $query);
if (!empty($params)) {
    mysqli_stmt_bind_param($stmt, $types, ...$params);
}
mysqli_stmt_execute($stmt);
$orders_result = mysqli_stmt_get_result($stmt);

// Show notification if exists
if (isset($_SESSION['notification'])) {
    echo "<script>
        showNotification('" . addslashes($_SESSION['notification']['message']) . "', 
                        '" . $_SESSION['notification']['type'] . "');
    </script>";
    unset($_SESSION['notification']);
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Orders</title>
    <script src="mo.js"></script>
    <!-- <link rel="stylesheet" href="style.css"> -->
    <!-- <link rel="stylesheet" href="mo.css"> -->
    <link rel="icon" href="../User/dp56vcf7.png" type="image/png">
    <script src="https://kit.fontawesome.com/8341c679e5.js" crossorigin="anonymous"></script>
</head>
<style>
    /* Admin Header */
    .admin-header {
        background-color: #f3f3f3;
        color: white;
        padding: 20px;
        text-align: center;
    }

    /* Admin Main Sections */
    .admin-section {
        margin: 20px;
        padding: 20px;
        border: 1px solid #ddd;
        background-color: #f9f9f9;
        border-radius: 8px;

    }

    /* Quick Stats Boxes */
    .stats-container {
        display: flex;
        justify-content: space-around;
        margin-top: 20px;
    }

    .stat-box {
        background-color: #007BFF;
        color: white;
        padding: 15px;
        border-radius: 8px;
        text-align: center;
        width: 30%;
    }

    /* Admin Tables */
    .admin-table {
        width: 100%;
        border-collapse: collapse;
    }

    .admin-table th,
    .admin-table td {
        padding: 10px;
        text-align: left;
        border-bottom: 1px solid #ddd;
    }

    .admin-table th {
        background-color: #f3f3f3;
        font-weight: bold;
    }


    /* Admin Buttons */
    .admin-table button {
        padding: 5px 10px;
        margin-right: 5px;
        background-color: #007BFF;
        color: white;
        border: none;
        border-radius: 4px;
        cursor: pointer;
    }

    .admin-table button:hover {
        background-color: #0056b3;
    }


    /* Navbar Styling */
    .navbar {
        background-color: #2c3e50;
        /* Darker color for admin navbar */
        overflow: hidden;
        font-weight: bold;
        padding: 10px 0;
        padding-left: 100px;
    }

    .navbar a {
        color: #ecf0f1;
        /* Light text color */
        float: left;
        display: block;
        text-align: center;
        padding: 14px 20px;
        text-decoration: none;
        transition: background-color 0.3s, color 0.3s;
        /* Smooth transition */
    }

    /* Hover Effects for Links */
    .navbar a:hover {
        background-color: #34495e;
        /* Slightly lighter background on hover */
        color: #1abc9c;
        /* Accent color for text on hover */
    }

    /* Active Link */
    .navbar a.active {
        background-color: #1abc9c;
        /* Highlight color for active page */
        color: #ffffff;
    }

    /* Dropdown Menu for Navbar (optional for sub-navigation) */
    .navbar .dropdown {
        float: left;
        overflow: hidden;
    }

    .navbar .dropdown .dropbtn {
        font-size: 16px;
        border: none;
        outline: none;
        color: #ecf0f1;
        padding: 14px 20px;
        background-color: inherit;
        font-family: inherit;
        margin: 0;
    }

    /* Dropdown Content (Hidden by Default) */
    .navbar .dropdown-content {
        display: none;
        position: absolute;
        background-color: #34495e;
        min-width: 160px;
        z-index: 1;
        box-shadow: 0px 8px 16px rgba(0, 0, 0, 0.2);
    }

    /* Links inside Dropdown */
    .navbar .dropdown-content a {
        float: none;
        color: #ecf0f1;
        padding: 12px 16px;
        text-decoration: none;
        display: block;
        text-align: left;
    }

    .navbar .dropdown-content a:hover {
        background-color: #1abc9c;
        /* Highlight for dropdown items on hover */
    }

    /* Show Dropdown on Hover */
    .navbar .dropdown:hover .dropdown-content {
        display: block;
    }

    #logoheader {
        max-width: 10%;
    }


    /* Styling for Admin Info in Header */
    .admin-info {
        display: flex;
        align-items: center;
        gap: 15px;
        margin-right: 20px;
        font-size: 16px;
        color: #000000;
        font-size: 1.5em;
        font-weight: bold;
    }

    #logout-btn {
        background-color: #e74c3c;
        color: white;
        border: none;
        padding: 8px 12px;
        border-radius: 4px;
        cursor: pointer;
        font-size: 14px;
        transition: background-color 0.3s ease;
    }

    #logout-btn:hover {
        background-color: #c0392b;
    }

    Specific hover effect for Ban button .admin-table button[style*="background-color: red;"] {
        background-color: #e74c3c;
        color: white;
        border: none;
        transition: background-color 0.3s ease, transform 0.2s ease;
    }

    .admin-table button[style*="background-color: red;"]:hover {
        background-color: #c0392b;
        /* Darker red on hover  */
        transform: scale(1.1);
        /* Slight zoom effect  */
        box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.2);
        /* Add shadow  */
    }

    /* More Button Styling */
    button.link {
        margin-top: 20px;
        display: inline-block;
        background-color: #1abc9c;
        /* Màu nền xanh ngọc */
        color: white;
        /* Màu chữ trắng */
        border: none;
        border-radius: 8px;
        padding: 10px 20px;
        /* Kích thước nút */
        font-size: 16px;
        /* Kích thước chữ */
        font-weight: bold;
        /* Đậm chữ */
        cursor: pointer;
        /* Hiển thị icon tay khi hover */
        transition: background-color 0.3s ease, box-shadow 0.3s ease;
        /* Hiệu ứng mượt */
        text-align: center;
        /* Canh giữa văn bản */
    }

    /* Hover Effect for More Button */
    button.link:hover {
        background-color: #16a085;
        /* Màu nền đậm hơn khi hover */
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        /* Đổ bóng khi hover */
    }

    /* Active State for More Button */
    button.link:active {
        background-color: #0e7766;
        /* Màu tối hơn khi bấm */
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);
        /* Giảm độ cao bóng */
    }

    /* Add this to style.css */
    #logout-btn {
        text-decoration: none;
        color: #fff;
        background-color: #dc3545;
        padding: 8px 16px;
        border-radius: 4px;
        border: none;
        cursor: pointer;
        display: inline-flex;
        align-items: center;
    }

    #logout-btn:hover {
        background-color: #c82333;
    }

    /* Add this CSS to your existing styles */
    .filter-container {
        background: white;
        border-radius: 8px;
        box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        margin-bottom: 30px;
    }
    
    .filter-container h2 {
        color: #2c3e50;
        font-size: 1.5rem;
        margin-bottom: 20px;
        display: flex;
        align-items: center;
        gap: 10px;
    }
    
    .filter-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
        gap: 20px;
        margin-bottom: 25px;
    }
    
    .filter-group {
        display: flex;
        flex-direction: column;
        gap: 8px;
    }
    
    .filter-group label {
        color: #34495e;
        font-weight: 500;
        display: flex;
        align-items: center;
        gap: 8px;
    }
    
    .filter-group label i {
        color: #1abc9c;
        width: 16px;
    }
    
    .filter-group input,
    .filter-group select {
        padding: 10px;
        border: 1px solid #e0e0e0;
        border-radius: 6px;
        font-size: 14px;
        transition: all 0.3s ease;
        background: #f8f9fa;
    }
    
    .filter-group input:focus,
    .filter-group select:focus {
        border-color: #1abc9c;
        box-shadow: 0 0 0 3px rgba(26, 188, 156, 0.1);
        outline: none;
    }
    
    .filter-buttons {
        display: flex;
        gap: 15px;
        justify-content: flex-end;
        padding-top: 20px;
        border-top: 1px solid #eee;
    }
    
    .filter-btn, 
    .reset-btn {
        padding: 10px 20px;
        border: none;
        border-radius: 6px;
        font-weight: 500;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        transition: all 0.3s ease;
    }
    
    .filter-btn {
        background: linear-gradient(135deg, #1abc9c, #16a085);
        color: white;
    }
    
    .reset-btn {
        background: #f8f9fa;
        color: #666;
        border: 1px solid #ddd;
        text-decoration: none;
    }
    
    .filter-btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 15px rgba(26, 188, 156, 0.3);
    }
    
    .reset-btn:hover {
        background: #e9ecef;
        transform: translateY(-2px);
    }
    
    @media (max-width: 768px) {
        .filter-grid {
            grid-template-columns: 1fr;
        }
        
        .filter-buttons {
            flex-direction: column;
        }
        
        .filter-btn,
        .reset-btn {
            width: 100%;
            justify-content: center;
        }
    }
</style>

<style>
    .admin-section {
        margin: 20px;
        padding: 20px;
        background: white;
        border-radius: 8px;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
    }

    .admin-table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 20px;
    }

    .admin-table th,
    .admin-table td {
        padding: 12px;
        text-align: left;
        border-bottom: 1px solid #eee;
    }

    .admin-table th {
        background: #f8f9fa;
        font-weight: 600;
        color: #2c3e50;
    }

    .status-badge {
        padding: 6px 12px;
        border-radius: 20px;
        font-size: 14px;
        font-weight: 500;
    }

    .status-initiated {
        background: #e3f2fd;
        color: #1976d2;
    }

    .status-is-pending {
        background: #fff3e0;
        color: #f57c00;
    }

    .status-is-confirmed {
        background: #e8f5e9;
        color: #2e7d32;
    }

    .status-is-delivering {
        background: #ede7f6;
        color: #5e35b1;
    }

    .status-completed {
        background: #e0f7fa;
        color: #00796b;
    }

    .status-cancelled {
        background: #ffebee;
        color: #c62828;
    }

    .edit-status-btn {
        padding: 6px 12px;
        border: none;
        border-radius: 4px;
        background: linear-gradient(135deg, #1abc9c, #16a085);
        color: white;
        cursor: pointer;
        transition: all 0.3s ease;
        text-decoration: none;
    }

    .edit-status-btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 20px rgba(26, 188, 156, 0.3);
    }

    /* Status Modal Styles */
    .status-modal {
        display: none;
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0, 0, 0, 0.5);
        z-index: 1000;
    }

    .modal-content {
        position: relative;
        background: white;
        width: 90%;
        max-width: 500px;
        margin: 50px auto;
        padding: 20px;
        border-radius: 8px;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.2);
    }

    .status-select {
        width: 100%;
        padding: 10px;
        margin: 10px 0;
        border: 1px solid #ddd;
        border-radius: 4px;
    }

    .modal-buttons {
        display: flex;
        justify-content: flex-end;
        gap: 10px;
        margin-top: 20px;
    }

    .modal-btn {
        padding: 8px 16px;
        border: none;
        border-radius: 4px;
        cursor: pointer;
        transition: all 0.3s ease;
    }

    .save-btn {
        background: #1abc9c;
        color: white;
    }

    .cancel-btn {
        background: #95a5a6;
        color: white;
    }
/* Add to your existing styles */
.admin-table th {
    background: #f8f9fa;
    font-weight: 600;
    color: #2c3e50;
}

.admin-table th i {
    margin-right: 8px;
    color: #1abc9c;
    width: 16px;
    text-align: center;
}

.admin-table th:hover i {
    transform: scale(1.1);
    transition: transform 0.2s ease;
}
</style>

<body>


    <main>
        <!-- Filter & Sorting Section -->
        <!-- Replace the filter section HTML with this -->
        <div class="admin-section filter-container">
            <h2><i class="fas fa-filter"></i> Filter & Sort Orders</h2>
            <form method="GET" action="manage-orders.php" class="filters">
                <div class="filter-grid">
                    <!-- Date Range Filter -->
                    <div class="filter-group">
                        <label for="start-date"><i class="far fa-calendar-alt"></i> Start Date:</label>
                        <input type="date" id="start-date" name="start_date"
                            value="<?= htmlspecialchars($_GET['start_date'] ?? '') ?>">
                    </div>

                    <div class="filter-group">
                        <label for="end-date"><i class="far fa-calendar-alt"></i> End Date:</label>
                        <input type="date" id="end-date" name="end_date"
                            value="<?= htmlspecialchars($_GET['end_date'] ?? '') ?>">
                    </div>

                    <!-- Status Filter -->
                    <div class="filter-group">
                        <label for="status"><i class="fas fa-tag"></i> Status:</label>
                        <select id="status" name="status">
                            <option value="all">All Statuses</option>
                        <?php
                        $statuses = [
                            'initiated' => 'Initiated',
                            'is pending' => 'Is pending',
                            'is confirmed' => 'Is confirmed',
                            'is delivering' => 'Is delivering',
                            'completed' => 'Completed',
                            'cancelled' => 'Cancelled'
                        ];
                        foreach ($statuses as $value => $label) {
                            $selected = (isset($_GET['status']) && $_GET['status'] === $value) ? 'selected' : '';
                            echo "<option value='$value' $selected>$label</option>";
                        }
                        ?>
                        </select>
                    </div>

                    <!-- Sort Options -->
                    <div class="filter-group">
                        <label for="sort"><i class="fas fa-sort"></i> Sort by:</label>
                        <select id="sort" name="sort">
                            <option value="date_desc" <?= ($sort === 'date_desc') ? 'selected' : '' ?>>
                                <i class="fas fa-clock"></i> Newest First
                            </option>
                            <option value="date_asc" <?= ($sort === 'date_asc') ? 'selected' : '' ?>>
                                <i class="fas fa-clock"></i> Oldest First
                            </option>
                            <option value="location" <?= ($sort === 'location') ? 'selected' : '' ?>>
                                <i class="fas fa-map-marker-alt"></i> Location
                            </option>
                        </select>
                    </div>
                </div>

                <div class="filter-buttons">
                    <button type="submit" class="filter-btn">
                        <i class="fas fa-filter"></i> Apply Filters
                    </button>
                    <a href="manage-orders.php" class="reset-btn">
                        <i class="fas fa-undo"></i> Reset
                    </a>
                </div>
            </form>
        </div>


        <div class="admin-section">
            <h2><i class="fas fa-list-check"></i>&nbsp;Manage Orders</h2>

            <table class="admin-table">
                <thead>
                    <tr>
                        <th><i class="fas fa-hashtag"></i> ID</th>
                        <th><i class="far fa-calendar-alt"></i> Order Date</th>
                        <th><i class="fas fa-user"></i> Full Name/Username</th>
                        <th style="width: 20%;"><i class="fas fa-map-marker-alt"></i> Address</th>
                        <th><i class="fas fa-phone"></i> Phone Number</th>
                        <th><i class="fas fa-envelope"></i> Email</th>
                        <th><i class="fas fa-money-bill-wave"></i> Total Amount</th>
                        <th><i class="fas fa-info-circle"></i> Status</th>
                        <th><i class="fas fa-cogs"></i> Action</th>
                    </tr>
                </thead>
                                <!-- Fix the table rows closing tag -->
                <tbody>
                    <?php while ($order = mysqli_fetch_assoc($orders_result)): ?>
                        <tr>
                            <td>#<?= htmlspecialchars($order['order_id']) ?></td>
                            <td><?= date('d/m/Y H:i', strtotime($order['order_date'])) ?></td>
                            <td>
                                <strong><?= htmlspecialchars($order['full_name']) ?></strong><br>
                                <small><?= htmlspecialchars($order['username']) ?></small>
                            </td>
                            <td><?= htmlspecialchars($order['shipping_address']) ?></td>
                            <td><?= htmlspecialchars($order['phone_num']) ?></td>
                            <td><?= htmlspecialchars($order['email']) ?></td>
                            <td style="color:#008000;font-weight:bold;"><?= number_format($order['total_amount']) ?> ₫</td>
                            <td>
                                                                <!-- // Replace the span element with this cleaner version -->
                                <span class="status-badge status-<?= str_replace(' ', '-', strtolower($order['order_status'])) ?>">
                                    <?php
                                    switch ($order['order_status']) {
                                        case 'initiated': echo 'Initiated'; break;
                                        case 'is pending': echo 'Is pending'; break;
                                        case 'is confirmed': echo 'Is confirmed'; break;
                                        case 'is delivering': echo 'Is delivering'; break;
                                        case 'completed': echo 'Completed'; break;
                                        case 'cancelled': echo 'Cancelled'; break;
                                        default: echo $order['order_status'];
                                    }
                                    ?>

                            </td>
                            <td>
                                <a href="manage-orders.php?edit=<?= $order['order_id'] ?>" class="edit-status-btn">
                                    <i class="fas fa-edit"></i>
                                    Edit order status
                                </a>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>

        <!-- Status Edit Modal -->
        <!-- Replace the existing status modal div -->
        <div id="statusModal" class="status-modal"
            style="display: <?php echo isset($_GET['edit']) ? 'block' : 'none'; ?>">
            <div class="modal-content">
                <h3>Update order status</h3>
                <form action="manage-orders.php" method="POST">
                    <input type="hidden" name="order_id" value="<?php echo $_GET['edit'] ?? ''; ?>">
                    <select name="order_status" class="status-select">
                        <option value="initiated">Initiated</option>
                        <option value="is pending">Is pending</option>
                        <option value="is confirmed">Is confirmed</option>
                        <option value="is delivering">is delivering</option>
                        <option value="completed">Completed </option>
                        <option value="cancelled">Cancelled</option>
                    </select>
                    <div class="modal-buttons">
                        <a href="manage-orders.php" class="modal-btn cancel-btn">Cancel</a>
                        <button type="submit" name="update_status" class="modal-btn save-btn">Save changes</button>
                    </div>
                </form>
            </div>
        </div>
        <!-- <hr> -->
    </main>

    <script>
        // Close modal when clicking outside
        window.onclick = function (event) {
            if (event.target.className === 'status-modal') {
                window.location.href = 'manage-orders.php';
            }
        }
    </script>

</body>

</html>
<?php
include 'footer.php';
?>