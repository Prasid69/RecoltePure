document.addEventListener('DOMContentLoaded', () => {

  initCharts(); 
});

function initCharts() {

  /* Users vs Farmers Chart */
  const usersFarmersCanvas = document.getElementById('chartUsersFarmers');
  if (usersFarmersCanvas) {
    new Chart(usersFarmersCanvas, {
      type: 'bar',
      data: {
        labels: ['Users', 'Farmers'],
        datasets: [{
          data: [dashboardStats.users, dashboardStats.farmers],
          backgroundColor: ['#42a5f5', '#66bb6a']
        }]
      },
      options: {
        responsive: true,
        plugins: {
          legend: { display: false }
        }
      }
    });
  }

  const productsCategoryCanvas = document.getElementById('chartProductsByCategory');
  if (productsCategoryCanvas) {
    new Chart(productsCategoryCanvas, {
      type: 'pie',
      data: {
        labels: categoryData.labels,
        datasets: [{
          data: categoryData.values,
          backgroundColor: [
            '#42a5f5',
            '#66bb6a',
            '#ffa726',
            '#ab47bc',
            '#ef5350'
          ]
        }]
      },
      options: {
        responsive: true
      }
    });
  }


  document.addEventListener('DOMContentLoaded', function () {
    function createFarmerChart(canvasId, label, color) {
        const canvas = document.getElementById(canvasId);
        if (!canvas) return; 

        // Retrieve data from the data-attributes we set in PHP
        const labels = JSON.parse(canvas.getAttribute('data-labels') || '[]');
        const values = JSON.parse(canvas.getAttribute('data-values') || '[]');

        new Chart(canvas, {
            type: 'bar',
            data: {
                labels: labels,
                datasets: [{
                    label: label,
                    data: values,
                    backgroundColor: color,
                    borderRadius: 5
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    y: { beginAtZero: true }
                }
            }
        });
    }

    createFarmerChart('chartOrdersPerFarmer', 'Orders Completed', '#FF2A00');
    createFarmerChart('chartTopFarmers', 'Revenue Generated (€)', '#4CAF50');
});
}