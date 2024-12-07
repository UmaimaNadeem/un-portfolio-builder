document.addEventListener('DOMContentLoaded', function() {
    const sidebarToggleBtn = document.getElementById('sidebarToggleBtn');
    const sidebar = document.getElementById('sidebar');
    const mainContent = document.querySelector('.main-content');
    const overlay = document.getElementById('overlay');

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

    const ctx = document.getElementById('projectActivityChart').getContext('2d');
    const projectActivityChart = new Chart(ctx, {
        type: 'line',
        data: {
            labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul'],
            datasets: [{
                label: 'Project Activity',
                data: [12, 19, 3, 5, 2, 3, 7],
                borderColor: 'rgba(75, 192, 192, 1)',
                fill: false
            }]
        }
    });

    const ctx2 = document.getElementById('skillsDistributionChart').getContext('2d');
    const skillsDistributionChart = new Chart(ctx2, {
        type: 'pie',
        data: {
            labels: ['HTML', 'CSS', 'JavaScript', 'PHP', 'Laravel'],
            datasets: [{
                data: [30, 20, 25, 15, 10],
                backgroundColor: ['#FF6384', '#36A2EB', '#FFCE56', '#4BC0C0', '#FF5733']
            }]
        }
    });
});
