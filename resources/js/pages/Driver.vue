<template>
    <div
        class="driver-page flex flex-col items-center justify-center min-h-screen bg-gradient-to-r from-blue-400 via-blue-500 to-blue-600 text-white"
    >
        <h1 class="text-4xl font-extrabold mb-8 drop-shadow-lg">
            Register as a Driver
        </h1>
        <form
            @submit.prevent="submitDriver"
            class="bg-white p-6 rounded-lg shadow-lg text-blue-500 w-full max-w-md"
        >
            <label for="name" class="block mb-2 text-lg font-semibold"
                >Your full name</label
            >
            <div class="relative">
                <input
                    type="text"
                    id="name"
                    v-model="name"
                    required
                    class="p-3 mb-4 w-full border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                />
            </div>
            <label for="year" class="block mb-2 text-lg font-semibold"
                >Car Year:</label
            >
            <div class="relative">
                <input
                    type="number"
                    id="year"
                    v-model="year"
                    required
                    class="p-3 mb-4 w-full border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                />
            </div>

            <label for="make" class="block mb-2 text-lg font-semibold"
                >Car Make:</label
            >
            <div class="relative">
                <input
                    type="text"
                    id="make"
                    v-model="make"
                    required
                    class="p-3 mb-4 w-full border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                />
            </div>

            <label for="model" class="block mb-2 text-lg font-semibold"
                >Car Model:</label
            >
            <div class="relative">
                <input
                    type="text"
                    id="model"
                    v-model="model"
                    required
                    class="p-3 mb-4 w-full border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                />
            </div>

            <label for="color" class="block mb-2 text-lg font-semibold"
                >Car Color:</label
            >
            <div class="relative">
                <input
                    type="text"
                    id="color"
                    v-model="color"
                    required
                    class="p-3 mb-4 w-full border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                />
            </div>

            <label for="license_plate" class="block mb-2 text-lg font-semibold"
                >License Plate:</label
            >
            <div class="relative">
                <input
                    type="text"
                    id="license_plate"
                    v-model="license_plate"
                    required
                    class="p-3 mb-4 w-full border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                />
            </div>

            <button
                type="submit"
                class="w-full py-3 bg-blue-500 text-white font-semibold rounded-lg shadow-md transform transition-transform hover:scale-105 hover:bg-blue-600"
            >
                Submit
            </button>
        </form>
    </div>
</template>

<script setup>
import { ref } from "vue";
import axios from "axios";
import { useRouter } from "vue-router";
import http from '@/helpers/http';
const router = useRouter();

const year = ref("");
const name = ref("");
const make = ref("");
const model = ref("");
const color = ref("");
const license_plate = ref("");

const submitDriver = async () => {
    try {
        const response = await http().post("/api/driver", {
            year: year.value,
            name: name.value,
            make: make.value,
            model: model.value,
            color: color.value,
            license_plate: license_plate.value,
        });
        console.log("Driver created successfully:", response.data);
        router.push({
                    name: "standby",
                });
        // Handle success (e.g., show a success message, redirect, etc.)
    } catch (error) {
        console.error("Error creating driver:", error);
        // Handle error (e.g., show an error message)
    }
};
</script>

<style scoped>
.driver-page {
    min-height: 100vh;
}
</style>
