const CHART_CONFIG = {
  colors: {
    primary: '#0ea5e9',
    white: '#ffffff'
  },
  gradientStart: 'rgba(14, 165, 233, 0.2)',
  gradientEnd: 'rgba(14, 165, 233, 0)',
  fontSize: {
    tick: 11
  },
  gridColor: 'rgba(226, 232, 240, 0.6)',
  gridDash: [5, 5]
};

let chartDataset = {
  labels: [],
  data: []
};

document.addEventListener('DOMContentLoaded', function() {
  initializeTrendChart();
});

function initializeTrendChart() {
  const chartCanvas = document.getElementById('trendChart');
  if (!chartCanvas) return;
  const ctx = chartCanvas.getContext('2d');
  const gradient = createChartGradient(ctx);
  const chartDataConfig = {
    labels: window.chartLabels || [],
    datasets: [createDataset(gradient)]
  };
  const chartOptions = {
    responsive: true,
    maintainAspectRatio: false,
    plugins: { legend: { display: false } },
    scales: { y: createYAxisConfig(), x: createXAxisConfig() }
  };
  new Chart(ctx, { type: 'line', data: chartDataConfig, options: chartOptions });
}

function createChartGradient(ctx) {
  const gradient = ctx.createLinearGradient(0, 0, 0, 180);
  gradient.addColorStop(0, CHART_CONFIG.gradientStart);
  gradient.addColorStop(1, CHART_CONFIG.gradientEnd);
  return gradient;
}

function createDataset(gradient) {
  return {
    label: 'Laporan',
    data: window.chartData || [],
    fill: true,
    backgroundColor: gradient,
    borderColor: CHART_CONFIG.colors.primary,
    borderWidth: 3,
    tension: 0.4,
    pointRadius: 4,
    pointBackgroundColor: CHART_CONFIG.colors.primary,
    pointBorderColor: CHART_CONFIG.colors.white,
    pointBorderWidth: 2
  };
}

function createYAxisConfig() {
  return {
    beginAtZero: true,
    ticks: {
      stepSize: 5,
      color: '#94a3b8',
      font: { size: CHART_CONFIG.fontSize.tick }
    },
    grid: { color: CHART_CONFIG.gridColor, drawBorder: false, borderDash: CHART_CONFIG.gridDash }
  };
}

function createXAxisConfig() {
  return {
    grid: { display: false },
    ticks: { color: '#94a3b8', font: { size: CHART_CONFIG.fontSize.tick } }
  };
}
