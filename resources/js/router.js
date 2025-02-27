import { createRouter, createWebHistory } from "vue-router";
import ExampleComponent from "./components/ExampleComponent.vue";
import LoginComponent from "./pages/auth/Login.vue";
import RegisterComponent from "./pages/auth/Signup.vue";

const routes = [
    {
        path: "/example",
        name: "example",
        component: ExampleComponent,
    },
    {
        path: "/login",
        name: "login",
        component: LoginComponent,
    },
    {
        path: "/register",
        name: "register",
        component: RegisterComponent,
    },
    // Add more routes here
];

const router = createRouter({
    history: createWebHistory("/app"),
    routes,
});

export default router;
