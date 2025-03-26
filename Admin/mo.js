// filepath: 

document.addEventListener('DOMContentLoaded', function() {
    const startDate = document.getElementById('start-date');
    const endDate = document.getElementById('end-date');
    const statusFilter = document.getElementById('status-filter');
    const sortLocationBtn = document.getElementById('sort-location');
    let isLocationSorted = false;

    function applyFilters() {
        const filters = {
            start_date: startDate.value,
            end_date: endDate.value,
            status: statusFilter.value,
            sort_location: isLocationSorted
        };

        fetch('filter_orders.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify(filters)
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                updateOrdersTable(data.orders);
            } else {
                showNotification(data.message, 'error');
            }
        })
        .catch(error => {
            showNotification('Error applying filters', 'error');
        });
    }

    function updateOrdersTable(orders) {
        const tbody = document.querySelector('.admin-table tbody');
        tbody.innerHTML = '';

        orders.forEach(order => {
            const row = `
                <tr>
                    <td>#${order.order_id}</td>
                    <td>${formatDate(order.order_date)}</td>
                    <td>
                        <strong>${order.full_name}</strong><br>
                        <small>${order.username}</small>
                    </td>
                    <td>${order.shipping_address}</td>
                    <td>${order.phone_num}</td>
                    <td>${order.email}</td>
                    <td>${formatCurrency(order.total_amount)}</td>
                    <td>
                        <span class="status-badge status-${order.order_status}">
                            ${formatStatus(order.order_status)}
                        </span>
                    </td>
                    <td>
                        <a href="manage-orders.php?edit=${order.order_id}" class="edit-status-btn">
                            <i class="fas fa-edit"></i>
                            Edit order status
                        </a>
                    </td>
                </tr>
            `;
            tbody.innerHTML += row;
        });
    }

    // Event listeners
    startDate.addEventListener('change', applyFilters);
    endDate.addEventListener('change', applyFilters);
    statusFilter.addEventListener('change', applyFilters);
    sortLocationBtn.addEventListener('click', () => {
        isLocationSorted = !isLocationSorted;
        sortLocationBtn.classList.toggle('active');
        applyFilters();
    });

    // Helper functions
    function formatDate(dateString) {
        const date = new Date(dateString);
        return date.toLocaleDateString('vi-VN') + ' ' + 
               date.toLocaleTimeString('vi-VN', {hour: '2-digit', minute:'2-digit'});
    }

    function formatCurrency(amount) {
        return new Intl.NumberFormat('vi-VN', {
            style: 'currency',
            currency: 'VND'
        }).format(amount);
    }

    function formatStatus(status) {
        const statusMap = {
            'initiated': 'Initiated',
            'is pending': 'Is pending',
            'is confirmed': 'Is confirmed',
            'is delivering': 'Is delivering',
            'completed': 'Completed',
            'cancelled': 'Cancelled'
        };
        return statusMap[status] || status;
    }
});