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
        border-top: 1px solid rgba(255,255,255,0.1);
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
</style>
<footer class="admin-footer">
    <div class="footer-content">
        <div class="footer-section">
            <h3><i class="fa-solid fa-chart-line"></i> Quick Stats</h3>
            <ul>
                <li>Active Listings: 150</li>
                <li>Total Sales: 1.2T VND</li>
                <li>Active Users: 500+</li>
            </ul>
        </div>
        
        <div class="footer-section">
            <h3><i class="fa-solid fa-clock"></i> System Status</h3>
            <ul>
                <li>Last Update: <?php echo date('d/m/Y H:i'); ?></li>
                <li>Server Status: Online</li>
                <li>Version: 1.0.0</li>
            </ul>
        </div>

        <div class="footer-section">
            <h3><i class="fa-solid fa-headset"></i> Support</h3>
            <ul>
                <li><i class="fa-solid fa-phone"></i> Hotline: 1800-123-456</li>
                <li><i class="fa-solid fa-envelope"></i> admin@autocar.com</li>
                <li><i class="fa-solid fa-location-dot"></i> TP.HCM,VietNam</li>
            </ul>
        </div>
    </div>
    
    <div class="footer-bottom">
        <p>© 2024 Auto Car Admin Panel. All rights reserved.</p>
        <div class="admin-links">
            <a href="docs.php">Documentation</a> |
            <a href="privacy.php">Privacy Policy</a> |
            <a href="terms.php">Terms of Use</a>
        </div>
    </div>
</footer>