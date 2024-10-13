<template>
    <div class="text-white mb-8">
        <div class="places-input text-gray-800">
            <input type="text" class="w-full">
        </div>
        <div class="weather-container font-sans w-128 max-w-lg overflow-hidden bg-gray-900 shadow-lg mt-4">
        <div class="current-weather flex items-center justify-between px-6 py-8">
            <div class="flex items-center">
                <div>
                    <div class="text-6xl font-semibold">8</div>
                    <div class="">Feels like</div>
                </div>
                <div class="mx-5">
                    <div class="font-semibold">Cloudy</div>
                    <div>Toronto, Canada</div>
                </div>
            </div>
            <div>Two</div>
        </div> <!-- end current weather -->
        </div> <!-- end weather container -->
    </div>
</template>

<script>
export default {
    name: 'WeatherApp',
};
</script>

<style scoped>
/* Ваши стили здесь */
</style>
