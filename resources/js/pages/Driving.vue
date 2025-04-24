<template>
    <div
        class="location-page flex flex-col items-center justify-center min-h-screen bg-gradient-to-r from-blue-400 via-blue-500 to-blue-600 text-white"
    >
        <div class="w-80">
            <button
                @click="starttrip"
                :disabled="trip_started"
                type="submit"
                class="w-full py-3 bg-blue-500 text-white font-semibold rounded-lg shadow-md transform transition-transform hover:scale-105 hover:bg-blue-600 disabled:opacity-50 disabled:cursor-not-allowed disabled:transform-none"
            >
                {{ trip_started ? "trip started" : "take the pessenger" }}
            </button>
        </div>
        <div class="w-80 mt-5 ">
            <button
                @click="endtrip"
                :disabled="!trip_started"
                type="submit"
                class="w-full py-3 bg-red-500 text-white font-semibold rounded-lg shadow-md transform transition-transform hover:scale-105 hover:bg-red-600 disabled:opacity-50 disabled:cursor-not-allowed disabled:transform-none"
            >
                end the trip
            </button>
        </div>

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
import axios from "axios";
import { useRouter } from "vue-router";

import L from "leaflet";

import http from "@/helpers/http";

import "leaflet-routing-machine"; // Import the library
import "leaflet-routing-machine/dist/leaflet-routing-machine.css"; //Import the style
import "leaflet/dist/leaflet.css";

const router = useRouter();
const map = ref(null);
const center = ref([9.9356124, -84.1483645]); // Default to a location
const zoom = ref(10);
const location = ref("");
const location_coordinates = ref([]);
const destination = ref("");
const destination_coordinates = ref([]);
const locationSuggestions = ref([]);
const destinationSuggestions = ref([]);
const locationMarker = ref(null);
const destinationMarker = ref(null);

const trip_id = ref(null);
const trip_started = ref(false);

const debugRoutingEvent = (event) => {
    console.log(`${event.type} event: `, event);
};

const url = "https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png";
const attribution =
    '&copy; <a href="http://osm.org/copyright">OpenStreetMap</a> contributors';

async function checkForTrip() {
    try {
        const response = await http().get("/api/trip");
        if (response.data) {
            console.log(response.data);
            destination.value = response.data.destination_name;
            location.value = response.data.origin_name;
            trip_id.value = response.data.id;
            trip_started.value = response.data.is_started;
            console.log(trip_started.value);
            // user_id.value = response.data.user_id;

            if (trip_started.value) {
                locationMarker.value = [
                    parseFloat(response.data.origin.lat),
                    parseFloat(response.data.origin.lng),
                ];

                destinationMarker.value = [
                    parseFloat(response.data.destination.lat),
                    parseFloat(response.data.destination.lng),
                ];
            } else {
                locationMarker.value = [
                    parseFloat(response.data.driver_location.latitude),
                    parseFloat(response.data.driver_location.longitude),
                ];

                destinationMarker.value = [
                    parseFloat(response.data.origin.lat),
                    parseFloat(response.data.origin.lng),
                ];
            }

            return;
        }
        // await router.push({ name: "standby" });
    } catch (error) {
        await router.push({ name: "standby" });
        console.log(error);
    }
}

onMounted(() => {
    checkForTrip();

    /*    if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(
            function (position) {
                console.log("Latitude: " + position.coords.latitude);
            },
            function (error) {
                console.error("Error getting location:", error);
            }
        );
    } else {
        console.log("Geolocation is not supported by this browser.");
    } */
});

const starttrip = () => {
    http()
        .post(`/api/trip/${trip_id.value}/start`)
        .then((response) => {
            trip_started.value = true;
            locationMarker.value = [
                parseFloat(response.data.origin.lat),
                parseFloat(response.data.origin.lng),
            ];

            destinationMarker.value = [
                parseFloat(response.data.destination.lat),
                parseFloat(response.data.destination.lng),
            ];

            console.log(response);
        })
        .catch((error) => {
            console.error(error);
        });
};
const endtrip = () => {
    http()
        .post(`/api/trip/${trip_id.value}/end`)
        .then((response) => {
            // router.push({ name: "standby" });
        })
        .catch((error) => {
            console.error(error);
        });
};
</script>
