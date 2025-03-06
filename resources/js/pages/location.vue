<template>
    <div
        class="location-page flex flex-col items-center justify-center min-h-screen bg-gradient-to-r from-blue-400 via-blue-500 to-blue-600 text-white">
        <h1 class="text-4xl font-extrabold mb-8 drop-shadow-lg">
            Choose Your Location
        </h1>
        <form @submit.prevent="submitLocation" class="bg-white p-6 rounded-lg shadow-lg text-blue-500 w-full max-w-md">
            <label for="location" class="block mb-2 text-lg font-semibold">Enter your destination:</label>
            <input type="text" id="location" v-model="location" required
                class="p-3 mb-4 w-full border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" />
            <button type="submit"
                class="w-full py-3 bg-blue-500 text-white font-semibold rounded-lg shadow-md transform transition-transform hover:scale-105 hover:bg-blue-600">
                Submit
            </button>
        </form>

        <div>
            <p v-if="geolocation.isSupported && geolocation.coords">
                Latitude: {{ geolocation.coords.value.latitude }}<br />
                Longitude: {{ geolocation.coords.value.longitude }}
            </p>
            <p v-else-if="geolocation.error">Error: {{ geolocation.error.message }}</p>
            <p v-else-if="!geolocation.isSupported">Geolocation is not supported</p>
            <p v-else>Loading location...</p>
            <div v-if="geolocation.error">
                <p>Debug info:</p>
                <pre>{{ geolocation.error }}</pre>
            </div>
        </div>

        <l-map :zoom="zoom" :center="center" style="height: 400px;">
            <l-tile-layer :url="url" :attribution="attribution"></l-tile-layer>
        </l-map>
    </div>
</template>

<script setup>
import { useGeolocation } from '@vueuse/core';

const geolocation = useGeolocation();

console.log(geolocation);
</script>





<style scoped>
.location-page {
    min-height: 100vh;
}
</style>



<script>
import "leaflet/dist/leaflet.css";
import { LMap, LTileLayer } from "@vue-leaflet/vue-leaflet";

export default {
  components: { LMap, LTileLayer },
  data() {
    return {
      zoom: 10,
      center: [9.9356124, -84.1483645],
      url: "https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png",
      attribution: '&copy; <a href="http://osm.org/copyright">OpenStreetMap</a> contributors',
    };
  },
};
</script>
