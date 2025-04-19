<template>
    <div
        class="standby-page flex flex-col items-center justify-center min-h-screen bg-gradient-to-r from-blue-400 via-blue-500 to-blue-600 text-white"
    >
        <h1 class="text-4xl font-extrabold mb-8 drop-shadow-lg">All Trips</h1>
        <div
            class="bg-white p-6 rounded-lg shadow-lg text-blue-500 w-full max-w-4xl"
        >
            <!-- <ul v-if="trips.length > 0">
                <li
                    v-for="trip in trips"
                    :key="trip.id"
                    class="p-4 mb-4 border-b border-gray-200"
                >
                    <div class="flex justify-between items-center">
                        <div>
                            <h2 class="text-xl font-semibold">
                                {{ trip.name }}
                            </h2>
                            <p>From: {{ trip.location }}</p>
                            <p>To: {{ trip.destination }}</p>
                            <p>
                                Car: {{ trip.make }} {{ trip.model }} ({{
                                    trip.year
                                }})
                            </p>
                            <p>Color: {{ trip.color }}</p>
                            <p>License Plate: {{ trip.license_plate }}</p>
                        </div>
                        <div>
                            <button
                                @click="startTrip(trip.id)"
                                class="py-2 px-4 bg-green-500 text-white font-semibold rounded-lg shadow-md transform transition-transform hover:scale-105 hover:bg-green-600"
                            >
                                Start Trip
                            </button>
                        </div>
                    </div>
                </li>
            </ul> -->
            <!-- <div v-else class="flex justify-center items-center">
                <Loader />
            </div> -->
        </div>
    </div>
</template>

<script setup>
import { ref, onMounted } from "vue";
import axios from "axios";
import Loader from "../components/Loader.vue";

const trips = ref([]);

onMounted(() => {
    Echo.channel("trips")
        .listen("TripCreated", (e) => {
            console.log("🎯 Trip received!", e);
        });
});
</script>

<style scoped>
.standby-page {
    min-height: 100vh;
}
</style>
