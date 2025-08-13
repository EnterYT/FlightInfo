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
    data() {
        return {
            chart: null
        }
    },
    mounted() {
        this.createChart()
    },
    watch: {
        labels: {
            handler() {
                this.updateChart()
            },
            deep: true
        },
        values: {
            handler() {
                this.updateChart()
            },
            deep: true
        }
    },
    methods: {
        createChart() {
            if (this.chart) {
                this.chart.destroy()
            }
            
            this.chart = new Chart(this.$refs.chartCanvas, {
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
                        },
                        borderColor: '#ff7300',
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: { display: false }
                    },
                    scales: {
                        y: { 
                            beginAtZero: true,
                            ticks: {
                                callback: function(value) {
                                    return value + 'M'
                                }
                            }
                        }
                    }
                }
            })
        },
        
        updateChart() {
            if (this.chart) {
                this.chart.data.labels = this.labels
                this.chart.data.datasets[0].data = this.values
                this.chart.update()
            }
        }
    },
    
    beforeUnmount() {
        if (this.chart) {
            this.chart.destroy()
        }
    }
}
</script>
