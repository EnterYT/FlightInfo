<template>
    <div class="min-h-screen bg-gradient-to-b from-purple-200 to-purple-50">
        <Header
            :years="[2020, 2021, 2022, 2023, 2024, 2025]"
            :activeYear="year"
            userName="Ахметов Ахмет"
            avatarUrl="https://via.placeholder.com/40"
            @year-selected="handleYearChange"
        />
        <TitleBar />
        <div class="grid grid-cols-3 gap-4 p-6">
            <div class="col-span-2">
                <Chart :labels="labels" :values="values" />
            </div>
            <Stats :total="totalPassengers" :domestic="domesticPassengers" :international="internationalPassengers" />
        </div>
        <div v-if="loading" class="text-center py-8">
            <div class="text-lg text-gray-600">Загрузка данных...</div>
        </div>
        <div v-if="error" class="text-center py-8">
            <div class="text-lg text-red-600">Ошибка загрузки: {{ error }}</div>
        </div>
    </div>
</template>

<script>
import Header from '../components/Header.vue'
import TitleBar from '../components/TitleBar.vue'
import Chart from '../components/Chart.vue'
import Stats from '../components/Stats.vue'
import axios from 'axios'

export default {
    components: { Header, TitleBar, Chart, Stats },
    data() {
        return {
            year: 2024,
            labels: [],
            values: [],
            totalPassengers: 0,
            domesticPassengers: 0,
            internationalPassengers: 0,
            loading: false,
            error: null
        }
    },
    mounted() {
        this.fetchData()
    },
    methods: {
        async fetchData() {
            this.loading = true
            this.error = null
            
            try {
                const response = await axios.get('/api/flights', {
                    params: {
                        from: `${this.year}-01`,
                        to: `${this.year}-12`
                    }
                })
                
                this.processData(response.data.data)
            } catch (err) {
                this.error = err.response?.data?.message || 'Ошибка загрузки данных'
                console.error('API Error:', err)
            } finally {
                this.loading = false
            }
        },
        
        processData(data) {
            // Group data by month and category
            const monthlyData = {}
            
            data.forEach(item => {
                const month = item.month
                if (!monthlyData[month]) {
                    monthlyData[month] = { domestic: 0, international: 0 }
                }
                
                if (item.category === 'internal') {
                    monthlyData[month].domestic += item.passenger_count
                } else if (item.category === 'international') {
                    monthlyData[month].international += item.passenger_count
                }
            })
            
            // Prepare chart data
            const monthNames = ['Янв', 'Фев', 'Мар', 'Апр', 'Май', 'Июн', 'Июл', 'Авг', 'Сен', 'Окт', 'Ноя', 'Дек']
            this.labels = []
            this.values = []
            
            let totalDomestic = 0
            let totalInternational = 0
            
            for (let month = 1; month <= 12; month++) {
                this.labels.push(monthNames[month - 1])
                
                if (monthlyData[month]) {
                    const total = monthlyData[month].domestic + monthlyData[month].international
                    this.values.push(total / 1000000) // Convert to millions
                    totalDomestic += monthlyData[month].domestic
                    totalInternational += monthlyData[month].international
                } else {
                    this.values.push(0)
                }
            }
            
            // Update stats
            this.totalPassengers = ((totalDomestic + totalInternational) / 1000000).toFixed(1)
            this.domesticPassengers = (totalDomestic / 1000000).toFixed(1)
            this.internationalPassengers = (totalInternational / 1000000).toFixed(1)
        },
        
        handleYearChange(newYear) {
            this.year = newYear
            this.fetchData()
        }
    }
}
</script>
