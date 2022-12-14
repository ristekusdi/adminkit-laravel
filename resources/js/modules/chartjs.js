// Usage: https://www.chartjs.org/
import { Chart } from "chart.js/auto";

Chart.defaults.color = window.theme["gray-600"];
Chart.defaults.font.family = "'Inter', 'Helvetica Neue', 'Helvetica', 'Arial', sans-serif";
window.Chart = Chart;