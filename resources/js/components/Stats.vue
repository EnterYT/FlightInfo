<template>
    <div class="bg-purple-800 text-white p-4 rounded shadow text-center">
        <div class="text-4xl font-bold text-yellow-300">{{ total }}<span class="text-base"> млн.пасс</span></div>
        <div class="mt-4">
            <div class="bg-white text-red-500 rounded py-2 mb-2 font-bold">
                {{ domestic }} <span class="text-sm font-normal">по внутренним маршрутам</span>
            </div>
            <div class="bg-white text-orange-500 rounded py-2 font-bold">
                {{ international }} <span class="text-sm font-normal">по международным маршрутам</span>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    props: {
        total: Number,
        domestic: Number,
        international: Number
    }
}
</script>
