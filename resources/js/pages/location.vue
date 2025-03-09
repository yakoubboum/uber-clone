<template>
    <div
        class="location-page flex flex-col items-center justify-center min-h-screen bg-gradient-to-r from-blue-400 via-blue-500 to-blue-600 text-white"
    >
        <h1 class="text-4xl font-extrabold mb-8 drop-shadow-lg">
            Choose Your Location
        </h1>
        <form
            @submit.prevent="submitLocation"
            class="bg-white p-6 rounded-lg shadow-lg text-blue-500 w-full max-w-md"
        >
            <label for="location" class="block mb-2 text-lg font-semibold"
                >Enter your location:</label
            >
            <div class="relative">
                <input
                    type="text"
                    id="location"
                    v-model="location"
                    @input="fetchLocationSuggestions('location')"
                    required
                    class="p-3 mb-4 w-full border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                />
                <ul
                    v-if="locationSuggestions.length"
                    class="absolute z-10 bg-white border rounded-lg w-full mt-1"
                >
                    <li
                        v-for="suggestion in locationSuggestions"
                        :key="suggestion.place_id"
                        @click="selectLocation(suggestion, 'location')"
                        class="p-2 cursor-pointer hover:bg-blue-100"
                    >
                        {{ suggestion.display_name }}
                    </li>
                </ul>
            </div>
            <label for="destination" class="block mb-2 text-lg font-semibold"
                >Enter your destination:</label
            >
            <div class="relative">
                <input
                    type="text"
                    id="destination"
                    v-model="destination"
                    @input="fetchLocationSuggestions('destination')"
                    required
                    class="p-3 mb-4 w-full border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                />
                <ul
                    v-if="destinationSuggestions.length"
                    class="absolute z-10 bg-white border rounded-lg w-full mt-1"
                >
                    <li
                        v-for="suggestion in destinationSuggestions"
                        :key="suggestion.place_id"
                        @click="selectLocation(suggestion, 'destination')"
                        class="p-2 cursor-pointer hover:bg-blue-100"
                    >
                        {{ suggestion.display_name }}
                    </li>
                </ul>
            </div>
            <button
                type="submit"
                class="w-full py-3 bg-blue-500 text-white font-semibold rounded-lg shadow-md transform transition-transform hover:scale-105 hover:bg-blue-600"
            >
                Submit
            </button>
        </form>

        <l-map
            ref="map"
            :zoom="zoom"
            :center="center"
            style="height: 400px; width: 70%; margin: 20px"
        >
            <l-tile-layer :url="url" :attribution="attribution"></l-tile-layer>
            <l-marker
                v-if="locationMarker"
                :lat-lng="locationMarker"
            ></l-marker>
            <l-marker
                v-if="destinationMarker"
                :lat-lng="destinationMarker"
            ></l-marker>

            <l-routing-machine
                v-if="locationMarker && destinationMarker"
                :waypoints="[locationMarker, destinationMarker]"
                @routingstart="debugRoutingEvent"
                @routesfound="debugRoutingEvent"
                @routingerror="debugRoutingEvent"

            ></l-routing-machine>
        </l-map>
    </div>
</template>

<script setup>
import { ref, onMounted, watch } from "vue";
import { LMap, LTileLayer, LMarker } from "@vue-leaflet/vue-leaflet";
import { reactive } from "vue";
import { useGeolocation } from "@vueuse/core";
import LRoutingMachine from "../components/LRoutingMachine.vue";

import L from "leaflet";
import "leaflet-routing-machine"; // Import the library
import "leaflet-routing-machine/dist/leaflet-routing-machine.css"; //Import the style

import "leaflet/dist/leaflet.css";

const map = ref(null);
const center = ref([9.9356124, -84.1483645]); // Default to a location
const zoom = ref(10);
const location = ref("");
const destination = ref("");
const locationSuggestions = ref([]);
const destinationSuggestions = ref([]);
const locationMarker = ref(null);
const destinationMarker = ref(null);

const debugRoutingEvent = (event) => {
    console.log(`${event.type} event: `, event);
};

const url = "https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png";
const attribution =
    '&copy; <a href="http://osm.org/copyright">OpenStreetMap</a> contributors';

const geolocation = useGeolocation();

console.log(geolocation.coords.value.latitude);

const fetchLocationSuggestions = async (type) => {
    const query = type === "location" ? location.value : destination.value;
    if (query.length < 3) {
        if (type === "location") locationSuggestions.value = [];
        else destinationSuggestions.value = [];
        return;
    }

    const response = await fetch(
        `https://nominatim.openstreetmap.org/search?format=json&q=${query}`
    );
    const data = await response.json();

    if (type === "location") locationSuggestions.value = data;
    else destinationSuggestions.value = data;
};

const selectLocation = (suggestion, type) => {
    if (type === "location") {
        location.value = suggestion.display_name;
        locationSuggestions.value = [];
        locationMarker.value = [
            parseFloat(suggestion.lat),
            parseFloat(suggestion.lon),
        ];
        center.value = [parseFloat(suggestion.lat), parseFloat(suggestion.lon)];
    } else {
        destination.value = suggestion.display_name;
        destinationSuggestions.value = [];
        destinationMarker.value = [
            parseFloat(suggestion.lat),
            parseFloat(suggestion.lon),
        ];
    }
};






</script>

<style>
.leaflet-routing-alt {
    color: black;
}

</style>


