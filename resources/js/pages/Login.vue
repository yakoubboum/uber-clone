<script setup>
import { onMounted } from "vue";
import { App } from "../../api/api";
import Step1 from "./login/Step1Login.vue";
import Step2 from "./login/Step2Login.vue";
import { useLoginStore } from "../../stores/auth/login-store";



function redirectToGoogle(){
    window.location.href='/auth/redirect'
}

// const loginStore = useLoginStore();
// onMounted(() => {
//     loginStore.currentStep = Step1;
//     loginStore.step1 = Step1;
//     loginStore.step2 = Step2;
// });
</script>





<template>
    <div class="flex flex-row justify-between mt-40"></div>
</template>
