<template>
    <div class="text-white mb-8">
        <div class="places-input text-gray-800">
            <input type="text" class="w-full" />
        </div>
        <div class="weather-container font-sans w-128 max-w-lg rounded-3xl overflow-hidden bg-gray-900 shadow-lg mt-4">
            <div class="current-weather flex items-center justify-between px-6 py-8">
                <div class="flex items-center">
                    <div>
                        <div class="text-6xl font-semibold">{{ currentTemperature.actual }}°C</div>
                        <div class="mt-4">Feels like {{ currentTemperature.feels }}°C</div>
                    </div>
                    <div class="mx-5">
                        <div class="font-semibold">{{ currentTemperature.summary }}</div>
                        <div>{{ location.name }}</div>
                    </div>
                </div>
                <i :class="currentTemperature.icon" class="weather-icon w-24 h-9"></i> <!-- Здесь -->
            </div> <!-- end current weather -->

            <div class="future-weather text-sm bg-gray-800 px-6 py-8 overflow-hidden">
                <div
                    v-for="(day, index) in daily"
                    :key="index"
                    class="flex items-center"
                    :class="{ 'mt-8': index > 0 }"
                >
                    <div class="w-1/6 text-lg text-gray-200">{{ day.time }}</div>
                    <div class="w-4/6 px-4 flex items-center">
                        <i :class="day.icon"></i>
                        <div class="ml-3">{{ day.summary }}</div>
                    </div>
                    <div class="w-1/6 text-right">
                        <div>{{ Math.round(day.temperatureHigh) }}°C</div>
                        <div>{{ Math.round(day.temperatureLow) }}°C</div>
                    </div>
                </div>
            </div> <!-- end future weather -->
        </div> <!-- end weather container -->
    </div>
</template>


<script>
export default {
    name: 'WeatherApp',
    data() {
        return {
            weather: null,
            location: {
                'name': 'Kyiv, Ukraine',
                'lat': 50.4504,
                'lon': 30.5245,
            },
            currentTemperature: {
                actual: '',
                feels: '',
                summary: '',
                icon: '',
            },
            daily: [],
        };
    },
    mounted() {
        this.fetchData();
    },
    methods: {
        async fetchData() {
            try {
                const response = await fetch(`/weather?lat=${this.location.lat}&lon=${this.location.lon}`);
                if (!response.ok) {
                    throw new Error('Network response was not ok');
                }
                const data = await response.json();
                this.weather = data;


                this.currentTemperature.actual = Math.round(data.main.temp - 273.15);
                this.currentTemperature.feels = Math.round(data.main.feels_like - 273.15);
                this.currentTemperature.summary = data.weather[0].main;


                const weatherIconMap = {
                    "Clear": "fas fa-sun",
                    "Clouds": "fas fa-cloud",
                    "Rain": "fas fa-cloud-showers-heavy",
                    "Snow": "fas fa-snowflake",
                    "Drizzle": "fas fa-cloud-rain",
                    "Thunderstorm": "fas fa-bolt",
                };
                this.currentTemperature.icon = weatherIconMap[data.weather[0].main] || "wi wi-na";


                this.daily = data.daily.map(day => ({
                    time: new Date(day.dt * 1000).toLocaleDateString("en-US", { weekday: 'short' }),
                    summary: day.weather[0].main,
                    temperatureHigh: day.temp.max - 273.15,
                    temperatureLow: day.temp.min - 273.15,
                    icon: weatherIconMap[day.weather[0].main] || "wi wi-na"
                }));
                console.log(data);
            } catch (error) {
                console.error('Ошибка при получении данных о погоде:', error);
            }
        }
    }
};
</script>


<style scoped>
.weather-icon {
  font-size: 50px;
     margin-left: -30px;
}
</style>
