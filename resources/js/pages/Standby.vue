<template>
    <div
        class="standby-page flex flex-col items-center justify-center min-h-screen bg-gradient-to-r from-blue-400 via-blue-500 to-blue-600 text-white"
    >
        <h1 class="text-4xl font-extrabold mb-8 drop-shadow-lg">All Trips</h1>
        <div
            class="bg-white p-6 rounded-lg shadow-lg text-blue-500 w-full max-w-4xl"
        >
            <ul v-if="trips">
                <li
                    v-for="trip in trips"
                    :key="trip.id"
                    class="p-4 mb-4 border-b border-gray-200"
                >
                    <div class="flex justify-between items-center">
                        <div>
                            <p>From: {{ trip.origin_name }}</p>
                            <p>To: {{ trip.destination_name }}</p>
                        </div>
                        <div>
                            <button
                                class="py-2 px-4 bg-green-500 text-white font-semibold rounded-lg shadow-md transform transition-transform hover:scale-105 hover:bg-green-600"
                            >
                                Start Trip
                            </button>
                        </div>
                    </div>
                </li>
            </ul>
            <div v-else class="flex justify-center items-center">
                <Loader />
            </div>
        </div>
    </div>
</template>

<script setup>
import { ref, onMounted } from "vue";
import axios from "axios";
import http from "@/helpers/http";
import Loader from "../components/Loader.vue";

const trips = ref([]);

onMounted(() => {
    Echo.channel("trips").listen("TripCreated", (e) => {
        console.log("🎯 Trip received!", e);

        trips.value.unshift(e.trip);
    });

    http()
        .get("/api/trips")
        .then((response) => {
            if (response.data.success) {
                console.log(response.data.trips);
                trips.value = response.data.trips;
            }
        })
        .catch((error) => {
            console.log(error);
        });
});
</script>

<style scoped>
.standby-page {
    min-height: 100vh;
}
</style>
