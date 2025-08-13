<template>
    <div class="bg-white p-4 rounded shadow">
        <canvas ref="chartCanvas"></canvas>
    </div>
</template>

<script>
import { Chart, registerables } from 'chart.js'
Chart.register(...registerables)

export default {
    props: {
        labels: Array,
        values: Array
    },
    mounted() {
        new Chart(this.$refs.chartCanvas, {
            type: 'bar',
            data: {
                labels: this.labels,
                datasets: [{
                    data: this.values,
                    backgroundColor: (ctx) => {
                        const gradient = ctx.chart.ctx.createLinearGradient(0, 0, 0, 200)
                        gradient.addColorStop(0, '#ff7300')
                        gradient.addColorStop(1, '#ffcc00')
                        return gradient
                    }
                }]
            },
            options: {
                plugins: {
                    legend: { display: false }
                },
                scales: {
                    y: { beginAtZero: true }
                }
            }
        })
    }
}
</script>
