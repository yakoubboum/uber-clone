<script setup>
import { ref } from "vue";
import axios from "axios";
import { App } from "../../api/api";

const email = ref("");
const password = ref("");

const login = async () => {
    try {
        const response = await axios.post(`${App.apiBaseUrl}/login`, {
            email: email.value,
            password: password.value,
        });
        // Handle successful login
    } catch (error) {
        // Handle login error
    }
};

function redirectToGoogle() {
    window.location.href = "/auth/redirect";
}
</script>

<template>
    <div
        class="flex flex-col items-center justify-center min-h-screen bg-gray-100"
    >
        <div class="w-full max-w-md p-8 bg-white rounded-lg shadow-md">
            <div class="flex flex-col items-center mb-6">
                <img
                    :src="App.baseUrl + '/img/logo.png'"
                    alt="logo"
                    class="w-20 h-20"
                />
                <h1 class="text-2xl font-bold mt-4">Welcome to</h1>
                <h1 class="text-2xl font-bold">My App</h1>
            </div>

            <form @submit.prevent="login" class="w-full">
                <div class="mb-4">
                    <label
                        for="email"
                        class="block text-sm font-medium text-gray-700"
                        >Email</label
                    >
                    <input
                        type="email"
                        id="email"
                        v-model="email"
                        class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm"
                        required
                    />
                </div>

                <div class="mb-6">
                    <label
                        for="password"
                        class="block text-sm font-medium text-gray-700"
                        >Password</label
                    >
                    <input
                        type="password"
                        id="password"
                        v-model="password"
                        class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm"
                        required
                    />
                </div>

                <button
                    type="submit"
                    class="w-full flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500"
                >
                    Login
                </button>
            </form>
        </div>
    </div>
</template>
