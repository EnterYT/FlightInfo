<template>
    <header class="flex items-center justify-between px-6 py-3 bg-gradient-to-r from-purple-800 to-purple-500 text-white">
        <div class="flex gap-2">
            <button
                v-for="year in years"
                :key="year"
                @click="$emit('year-selected', year)"
                :class="['px-4 py-1 rounded', year === activeYear ? 'bg-gray-300 text-black' : 'bg-transparent border border-white']"
            >
                {{ year }}
            </button>
        </div>
        <div class="flex items-center gap-2">
            <span>{{ userName }}</span>
            <img :src="avatarUrl" alt="avatar" class="w-8 h-8 rounded-full" />
        </div>
    </header>
</template>

<script>
export default {
    props: {
        years: Array,
        activeYear: Number,
        userName: String,
        avatarUrl: String
    }
}
</script>
