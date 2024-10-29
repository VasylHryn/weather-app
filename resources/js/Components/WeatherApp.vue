<template>
    <div class="text-white mb-8">
        <div class="places-input text-gray-800">
            <input type="text" v-model="location.name" class="w-full" placeholder="Enter city name" />
        </div>
        <div class="weather-container font-sans w-128 max-w-lg rounded-3xl overflow-hidden bg-gray-900 shadow-lg mt-4">
            <!-- Current Weather Section -->
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
                <i :class="currentTemperature.icon" class="weather-icon w-24 h-9"></i>
            </div>

            <!-- Future Weather Section -->
            <div class="future-weather text-sm bg-gray-800 px-6 py-8 overflow-hidden">
                <h2 class="text-xl font-semibold mb-4">5-Day Forecast</h2>
                <div v-for="(day, index) in daily" :key="index" class="future-day flex items-center justify-between py-2 border-b border-gray-600">
                    <div class="day-name flex items-center">
                        <div class="mx-3">{{ day.date }}</div>
                        <i :class="day.icon" class="weather-icon w-12 h-12"></i>
                    </div>
                    <div class="flex flex-col items-end">
                        <div class="temp text-lg font-semibold">{{ day.temp }}°C</div>
                        <div class="summary text-xs">{{ day.summary }}</div>
                    </div>
                </div>
            </div>
        </div>
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

                console.log('Full weather data:', data);

                // Current weather
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

                // Future weather (daily forecast)
                this.daily = data.daily.map((day) => ({
                    date: new Date(day.dt * 1000).toLocaleDateString('en-US', {weekday: 'long'}),
                    temp: Math.round(day.temp.day - 273.15),
                    summary: day.weather[0].main,
                    icon: weatherIconMap[day.weather[0].main] || "wi wi-na",
                }));

                console.log('Current Temperature:', this.currentTemperature);
                console.log('Daily Forecast:', this.daily);
            } catch (error) {
                console.error('Error fetching weather data:', error);
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
