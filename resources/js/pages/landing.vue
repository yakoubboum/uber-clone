<template>
    <div
        class="landing-page flex flex-col items-center justify-center min-h-screen bg-gradient-to-r from-blue-400 via-blue-500 to-blue-600 text-white"
    >
        <h1 class="text-5xl font-extrabold mb-8 drop-shadow-lg">
            Welcome to Uber Clone
        </h1>
        <p class="text-lg mb-8 max-w-md text-center drop-shadow-md">
            Experience the best ride-sharing service with our Uber Clone app.
            Whether you need a ride or want to start driving, we've got you
            covered.
        </p>
        <div class="buttons flex space-x-4">
            <button
                @click="findRide"
                class="btn-primary px-6 py-3 rounded-full bg-white text-blue-500 font-semibold shadow-lg transform transition-transform hover:scale-105 hover:bg-blue-100"
            >
                Find a Ride
            </button>
            <button
                @click="startDriving"
                class="btn-secondary px-6 py-3 rounded-full bg-white text-blue-500 font-semibold shadow-lg transform transition-transform hover:scale-105 hover:bg-blue-100"
            >
                Start Driving
            </button>
        </div>
    </div>
</template>

<script setup>
import { useRouter } from "vue-router";

const router = useRouter();

function findRide() {
    router.push("/location");
}

function startDriving() {
    router.push("/start-driving");
}
</script>
