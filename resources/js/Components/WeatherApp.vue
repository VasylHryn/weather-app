<template>
    <div class="text-white mb-8">
        <div class="places-input text-gray-800">
            <input type="text" class="w-full">
        </div>
        <div class="weather-container font-sans w-128 max-w-lg rounded-3xl overflow-hidden bg-gray-900 shadow-lg mt-4">
        <div class="current-weather flex items-center justify-between px-6 py-8">
            <div class="flex items-center">
                <div>
                    <div class="text-6xl font-semibold">8°C</div>
                    <div class="mt-4">Feels like 8°C</div>
                </div>
                <div class="mx-5">
                    <div class="font-semibold">Cloudy</div>
                    <div>Toronto, Canada</div>
                </div>
            </div>
            <div>Two</div>
        </div> <!-- end current weather -->

            <div class="future-weather text-sm bg-gray-800 px-6 py-8 overflow-hidden">
            <div class="flex items-center">
                <div class="w-1/6 text-lg text-gray-200">TUE</div>
                <div class="w-4/6 px-4 flex items-center">
                    <div>icon</div>
                    <div class="ml-3">Cloudy with a chance of showers</div>
                </div>
              <div class="w-1/6 text-right">
                  <div>5</div>
                  <div>3</div>
              </div>
            </div>
                <div class="flex items-center mt-8">
                <div class="w-1/6 text-lg text-gray-200">TUE</div>
                <div class="w-4/6 px-4 flex items-center">
                    <div>icon</div>
                    <div class="ml-3">Cloudy with a chance of showers</div>
                </div>
              <div class="w-1/6 text-right">
                  <div>5</div>
                  <div>3</div>
              </div>
            </div>
                <div class="flex items-center mt-8">
                <div class="w-1/6 text-lg text-gray-200">TUE</div>
                <div class="w-4/6 px-4 flex items-center">
                    <div>icon</div>
                    <div class="ml-3">Cloudy with a chance of showers</div>
                </div>
              <div class="w-1/6 text-right">
                  <div>5</div>
                  <div>3</div>
              </div>
            </div>

            </div> <!-- end future weather -->



        </div> <!-- end weather container -->
    </div>
</template>

<script>
export default {
    name: 'WeatherApp',
    mounted() {
        this.fetchData()
    },
    methods: {
        fetchData() {
            fetch('https://api.openweathermap.org/data/2.5/weather?lat=51&lon=31&appid=API_KEY')
                .then(response => response.json())
                .then(data => {
                    console.log(data)
                })
        }
    }
};
</script>

<style scoped>
/* Ваши стили здесь */
</style>
