<template>
    <div
        class="landing-page flex flex-col items-center justify-center min-h-screen bg-gradient-to-r from-blue-400 via-blue-500 to-blue-600 text-white"
    >
        <h1 class="text-5xl font-extrabold mb-8 drop-shadow-lg">Welcome to Uber Clone</h1>
        <div class="buttons flex space-x-4">
            <button @click="findRide" class="btn-primary px-6 py-3 rounded-full bg-white text-blue-500 font-semibold shadow-lg transform transition-transform hover:scale-105">
                Find a Ride
            </button>
            <button @click="startDriving" class="btn-secondary px-6 py-3 rounded-full bg-white text-blue-500 font-semibold shadow-lg transform transition-transform hover:scale-105">
                Start Driving
            </button>
        </div>
    </div>
</template>

<script>
export default {
    name: "LandingPage",
    methods: {
        findRide() {
            // Logic to navigate to find a ride page
            this.$router.push("/location");
        },
        startDriving() {
            // Logic to navigate to start driving page
            this.$router.push("/start-driving");
        },
    },
};
</script>
