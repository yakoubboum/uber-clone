<template>
    <div class="min-h-screen flex items-center justify-center bg-gray-100">
        <div
            class="bg-white p-8 rounded-lg shadow-lg w-full max-w-md"
            v-if="!waitingOnVerification"
        >
            <h2 class="text-2xl font-bold mb-6 text-center">Login</h2>
            <form @submit.prevent="handleSubmit">
                <div class="mb-4">
                    <label for="name" class="block text-gray-700">Name</label>
                    <input
                        type="text"
                        id="name"
                        v-model="name"
                        class="mt-2 p-2 w-full border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                        placeholder="Enter your name"
                        required
                    />
                </div>
                <div class="mb-4">
                    <label for="phone" class="block text-gray-700"
                        >Phone Number</label
                    >
                    <input
                        v-maska
                        data-maska="+ (###) ##-##-##-##-##"
                        type="tel"
                        id="phone"
                        v-model="phone"
                        class="mt-2 p-2 w-full border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                        placeholder="Enter your phone number"
                        required
                    />
                </div>
                <button
                    type="submit"
                    class="w-full bg-blue-500 text-white py-2 rounded-lg hover:bg-blue-600 transition duration-300"
                >
                    Login
                </button>
            </form>
        </div>

        <div v-else class="bg-white p-8 rounded-lg shadow-lg w-full max-w-md">
            <h2 class="text-2xl font-bold mb-6 text-center">verify</h2>
            <form @submit.prevent="handleVerification">
                <div class="mb-4">
                    <label for="login_code" class="block text-gray-700"
                        >Login code</label
                    >
                    <input
                        type="text"
                        id="login_code"
                        v-model="login_code"
                        class="mt-2 p-2 w-full border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                        placeholder="Enter the login code"
                        required
                    />
                </div>
                <button
                    type="submit"
                    class="w-full bg-blue-500 text-white py-2 rounded-lg hover:bg-blue-600 transition duration-300"
                >
                    Login
                </button>
            </form>
        </div>
    </div>
</template>

<style scoped>
/* Add any additional styles if needed */
</style>

<script setup>
import { ref, onMounted } from "vue";
import { vMaska } from "maska/vue";
import axios from "axios";
import { useRouter } from "vue-router";

const router = useRouter();

const name = ref("");
const phone = ref("");
const login_code = ref("");
const waitingOnVerification = ref(false);

onMounted(() => {
    if (localStorage.getItem("token")) {
        router.push({
            name: "landing",
        });
    }
});

function handleSubmit() {
    axios
        .post("http://127.0.0.1:8000/api/login", {
            name: name.value,
            phone: phone.value
                .replaceAll(" ", "")
                .replace("(", "")
                .replace(")", "")
                .replaceAll("-", ""),
        })
        .then((response) => {
            console.log(response.data);
            waitingOnVerification.value = true;
        })
        .catch((error) => {
            alert(error.response.data.message);
        });
}
function handleVerification() {
    axios
        .post("http://127.0.0.1:8000/api/login/verify", {
            phone: phone.value
                .replaceAll(" ", "")
                .replace("(", "")
                .replace(")", "")
                .replaceAll("-", ""),
            login_code: login_code.value,
        })
        .then((response) => {
            console.log(response.data); // auth token
            localStorage.setItem("token", response.data);
            router.push({
                name: "landing",
            });
        })
        .catch((error) => {
            console.error(error);
            alert(error.response.data.message);
        });
}
</script>
