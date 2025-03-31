<?php
// Get system statistics
function getSystemStats($connect)
{
    $stats = [
        'active_listings' => 0,
        'total_sales' => 0,
        'active_users' => 0
    ];

    // Get active listings
    $query = "SELECT COUNT(*) as count FROM products WHERE status IN ('selling', 'discounting')";
    $result = mysqli_query($connect, $query);
    $stats['active_listings'] = mysqli_fetch_assoc($result)['count'];

    // Get total sales
    $query = "SELECT SUM(total_amount) as total FROM orders WHERE order_status != 'cancelled'";
    $result = mysqli_query($connect, $query);
    $stats['total_sales'] = mysqli_fetch_assoc($result)['total'] ?? 0;

    // Get active users
    $query = "SELECT COUNT(*) as count FROM users_acc WHERE status = 'activated'";
    $result = mysqli_query($connect, $query);
    $stats['active_users'] = mysqli_fetch_assoc($result)['count'];

    return $stats;
}

// Check server status
// function getServerStatus()
// {
//     $load = sys_getloadavg();
//     return $load[0] < 80 ? 'Online' : 'High Load';
// }

// Get system stats
$stats = getSystemStats($connect);
$server_status = 'online';
$system_version = '1.0.0'; // Could be loaded from config file
?>

<style>
    /* Admin Footer Styles */
    .admin-footer {
        background: #2c3e50;
        color: #ecf0f1;
        padding: 30px 0 15px;
        margin-top: 40px;
    }

    .footer-content {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 30px;
        max-width: 1200px;
        margin: 0 auto;
        padding: 0 20px;
    }

    .footer-section {
        padding: 15px;
    }

    .footer-section h3 {
        color: #1abc9c;
        font-size: 18px;
        margin-bottom: 15px;
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .footer-section ul {
        list-style: none;
        padding: 0;
    }

    .footer-section ul li {
        margin-bottom: 10px;
        display: flex;
        align-items: center;
        gap: 10px;
        opacity: 0.9;
        transition: opacity 0.3s ease;
    }

    .footer-section ul li:hover {
        opacity: 1;
    }

    .footer-bottom {
        margin-top: 30px;
        padding-top: 15px;
        border-top: 1px solid rgba(255, 255, 255, 0.1);
        text-align: center;
        font-size: 14px;
    }

    .admin-links {
        margin-top: 10px;
    }

    .admin-links a {
        color: #1abc9c;
        text-decoration: none;
        transition: color 0.3s ease;
        margin: 0 10px;
    }

    .admin-links a:hover {
        color: #16a085;
    }

    @media (max-width: 768px) {
        .footer-content {
            grid-template-columns: 1fr;
            gap: 20px;
        }

        .footer-section {
            text-align: center;
        }

        .footer-section ul li {
            justify-content: center;
        }
    }

    .status-dot {
        display: inline-block;
        width: 8px;
        height: 8px;
        border-radius: 50%;
        margin-right: 5px;
    }

    .status-online {
        background-color: #2ecc71;
    }

    .status-high.load {
        background-color: #e74c3c;
    }

    /* Add to existing responsive styles */
    @media (max-width: 768px) {
        .footer-section ul li i {
            width: 20px;
            text-align: center;
        }
    }
</style>

<footer class="admin-footer">
    <div class="footer-content">
        <div class="footer-section">
            <h3><i class="fa-solid fa-chart-line"></i> Quick Stats</h3>
            <ul>
                <li><i class="fa-solid fa-tag"></i> Active Listings:
                    <?php echo number_format($stats['active_listings']); ?></li>
                <li><i class="fa-solid fa-money-bill-wave"></i> Total Sales:
                    <?php echo number_format($stats['total_sales'] / 1000000000, 1) . 'T VND'; ?></li>
                <li><i class="fa-solid fa-users"></i> Activated Users: <?php echo number_format($stats['active_users']); ?>
                </li>
            </ul>
        </div>

        <div class="footer-section">
            <h3><i class="fa-solid fa-clock"></i> System Status</h3>
            <ul>
                <li><i class="fa-solid fa-calendar-check"></i> Last Update: <span id="time"><?php echo date('d/m/Y H:i'); ?></span></li>
                <li><i class="fa-solid fa-server"></i> Server Status:
                    <span class="status-dot status-<?php echo strtolower($server_status); ?>"></span>
                    <?php echo $server_status; ?>
                </li>
                <li><i class="fa-solid fa-code-branch"></i> Version: <?php echo htmlspecialchars($system_version); ?>
                </li>
            </ul>
        </div>

        <div class="footer-section">
            <h3><i class="fa-solid fa-headset"></i> Support</h3>
            <ul>
                <li><i class="fa-solid fa-phone"></i> Hotline: 1800-123-456</li>
                <li><i class="fa-solid fa-envelope"></i> admin@autocar.com</li>
                <li><i class="fa-solid fa-location-dot"></i> TP.HCM, Vietnam</li>
            </ul>
        </div>
    </div>

    <div class="footer-bottom">
        <p>© <?php echo date('Y'); ?> Auto Car Admin Panel. All rights reserved.</p>
        <div class="admin-links">
            <a href="#">Documentation</a> |
            <a href="#">Privacy Policy</a> |
            <a href="#">Terms of Use</a>
            <!-- <a href="docs.php">Documentation</a> |
            <a href="privacy.php">Privacy Policy</a> |
            <a href="terms.php">Terms of Use</a> -->
        </div>
    </div>
</footer>
<script>
   function UpdateTime() {
    const clock = document.getElementById('time');
    const date1 = document.getElementById('day-text');
    const ampmtext=document.getElementById('time-sub-text');
    function displayTime() {
      const time = new Date();
      const h = time.getHours();
      const hour = h.toString().padStart(2, 0);
      const m = time.getMinutes().toString().padStart(2, 0);
      const s = time.getSeconds().toString().padStart(2, 0);
      const ampm = h >= 12 ? 'PM' : 'AM';
      const d=time.getDate();
      const month=time.getMonth()+1;
      const year=time.getFullYear();
      const day=time.getDay();
      
      let monthName;
      switch(month)
      {
        case 1: monthName='January'; break;//bien get khi them name vao se chuyen so thanh chuoi tuong ung voi Date duoc get
        case 2: monthName='February'; break;
        case 3: monthName='March'; break;
        case 4: monthName='April'; break;
        case 5: monthName='May'; break;
        case 6: monthName='June'; break;
        case 7: monthName='July'; break;
        case 8: monthName='August'; break;
        case 9: monthName='September'; break;
        case 10: monthName='October'; break;
        case 11: monthName='November'; break;
        case 12: monthName='December'; break;
      }
      let dayName;
      switch(day)
      {
          case 0: dayName='Sunday'; break;
          case 1: dayName='Monday'; break;
          case 2: dayName='Tuesday'; break;
          case 3: dayName='Wednesday'; break;
          case 4: dayName='Thursday'; break;
          case 5: dayName='Friday'; break;
          case 6: dayName='Saturday'; break;
      }
      let daySuffix;  // thêm suffix cho ngày tháng để đảm bảo đ��nh dạng đúng theo tiếng Việt Nam
      switch(d)
      {
        case 1: case 21: case 31: daySuffix='st'; break;
        case 2: case 22: daySuffix='nd'; break;
        case 3: case 23: daySuffix='rd'; break;
        default: daySuffix='th'; break;  // for other numbers
      }

      clock.textContent = `${day}/ ${month} / ${year}  ${hour}:${m}:${s} `;
    //   ampmtext.textContent = `${ampm}`;  // hiển thị AM/PM
    //   date1.textContent = `${dayName}, ${monthName} ${d}${daySuffix}, ${year}  `;
    }
  
    // displayTime();
    setInterval(displayTime, 1000);
  }
  UpdateTime();
</script>