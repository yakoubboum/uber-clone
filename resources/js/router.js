import { createRouter, createWebHistory } from "vue-router";
import ExampleComponent from "./components/ExampleComponent.vue";
import LoginComponent from "./pages/auth/Login.vue";
import RegisterComponent from "./pages/auth/Signup.vue";
import LandingPage from "./pages/landing.vue";
import LocationPage from "./pages/location.vue";
import TripPage from "./pages/Trip.vue";
import StandbyPage from "./pages/Standby.vue";
import DriverPage from "./pages/Driver.vue";

const routes = [
    {
        path: "/example",
        name: "example",
        component: ExampleComponent,
    },
    {
        path: "/",
        name: "login",
        component: LoginComponent,
    },
    {
        path: "/register",
        name: "register",
        component: RegisterComponent,
    },
    {
        path: "/Landing",
        name: "landing",
        component: LandingPage,
    },
    {
        path: "/location",
        name: "location",
        component: LocationPage,
    },
    {
        path: "/trip",
        name: "trip",
        component: TripPage,
    },
    {
        path: "/standby",
        name: "standby",
        component: StandbyPage,
    },
    {
        path: "/driver",
        name: "driver",
        component: DriverPage,
    },
    // Add more routes here
];

const router = createRouter({
    history: createWebHistory("/"),
    routes,
});

router.beforeEach((to, from) => {
    if (to.name === "login") {
        return true;
    }

    if (!localStorage.getItem("token")) {
        return {
            name: "login",
        };
    }

    checkTokenAuthenticity();
});

const checkTokenAuthenticity = () => {
    axios
        .get("http://127.0.0.1:8000/api/user", {
            headers: {
                Authorization: `Bearer ${localStorage.getItem("token")}`,
            },
        })
        .then((response) => {})
        .catch((error) => {
            localStorage.removeItem("token");
            router.push({
                name: "login",
            });
        });
};

export default router;
