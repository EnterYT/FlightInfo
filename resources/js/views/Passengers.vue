<template>
    <div class="min-h-screen bg-gradient-to-b from-purple-200 to-purple-50">
        <Header
            :years="[2020, 2021, 2022, 2023, 2024, 2025]"
            :activeYear="year"
            userName="Ахметов Ахмет"
            avatarUrl="https://via.placeholder.com/40"
            @year-selected="year = $event"
        />
        <TitleBar />
        <div class="grid grid-cols-3 gap-4 p-6">
            <div class="col-span-2">
                <ChartBlock :labels="labels" :values="values" />
            </div>
            <Stats :total="8.3" :domestic="5.3" :international="3.0" />
        </div>
    </div>
</template>

<script>
import Header from '../components/Header.vue'
import TitleBar from '../components/TitleBar.vue'
import ChartBlock from '../components/ChartBlock.vue'
import Stats from '../components/Stats.vue'

export default {
    components: { Header, TitleBar, ChartBlock, Stats },
    data() {
        return {
            year: 2024,
            labels: ['Янв', 'Фев', 'Мар', 'Апр', 'Май', 'Июн', 'Июл', 'Авг', 'Сен', 'Окт'],
            values: [0.55, 0.76, 0.72, 0.64, 0.63, 0.45, 0.38, 0.91, 0.47, 0.79]
        }
    }
}
</script>
