document.addEventListener('DOMContentLoaded', function() {
    const sidebarToggleBtn = document.getElementById('sidebarToggleBtn');
    const sidebar = document.getElementById('sidebar');
    const mainContent = document.querySelector('.main-content');
    const overlay = document.getElementById('overlay');

    // Check if the elements exist before adding event listeners
    if (sidebarToggleBtn && sidebar && mainContent && overlay) {
        sidebarToggleBtn.addEventListener('click', function() {
            sidebar.classList.toggle('sidebar-hidden');
            mainContent.classList.toggle('hidden-sidebar');
            if (window.innerWidth <= 768) {
                sidebar.classList.toggle('show');
                overlay.classList.toggle('show');
            }
        });

        overlay.addEventListener('click', function() {
            sidebar.classList.remove('show');
            overlay.classList.remove('show');
        });
    } else {
        console.error('Some elements are missing in the HTML.');
    }

    // Initialize charts only if the elements exist
    const ctx = document.getElementById('productSalesChart');
    if (ctx) {
        const productSalesChart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: ['1 Jul', '2 Jul', '3 Jul', '4 Jul', '5 Jul', '6 Jul', '7 Jul'],
                datasets: [{
                    label: 'Gross Margin',
                    data: [30, 45, 55, 60, 50, 70, 80],
                    borderColor: 'rgba(255, 99, 132, 1)',
                    fill: false
                }, {
                    label: 'Revenue',
                    data: [40, 50, 60, 65, 55, 75, 85],
                    borderColor: 'rgba(54, 162, 235, 1)',
                    fill: false
                }]
            }
        });
    }

    const ctx2 = document.getElementById('salesByCategory');
    if (ctx2) {
        const salesByCategory = new Chart(ctx2, {
            type: 'pie',
            data: {
                labels: ['Living room', 'Kids', 'Office', 'Bedroom', 'Kitchen', 'Bathroom', 'Dining room'],
                datasets: [{
                    data: [25, 17, 12, 10, 9, 8, 5],
                    backgroundColor: ['#FF6384', '#36A2EB', '#FFCE56', '#4BC0C0', '#FF5733']
                }]
            }
        });
    }
});
