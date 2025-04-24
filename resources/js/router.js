import { createRouter, createWebHistory } from "vue-router";
import ExampleComponent from "./components/ExampleComponent.vue";
import LoginComponent from "./pages/auth/Login.vue";
import RegisterComponent from "./pages/auth/Signup.vue";
import LandingPage from "./pages/landing.vue";
import LocationPage from "./pages/location.vue";
import TripPage from "./pages/Trip.vue";
import StandbyPage from "./pages/Standby.vue";
import DriverPage from "./pages/Driver.vue";
import DrivingPage from "./pages/Driving.vue";

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

    {
        path: "/driving",
        name: "driving",
        component: DrivingPage,
    },
    // Add more routes here
];

const router = createRouter({
    history: createWebHistory("/app"),
    routes,
});

router.beforeEach(async (to, from, next) => {
    const token = localStorage.getItem("token");

    // If going to login page
    if (to.name === "login") {
        if (token) {
            // Check if token is valid
            const isAuthenticated = await checkTokenAuthenticity();
            if (isAuthenticated) {
                // If authenticated, redirect away from login page
                return next(from.name);
            }
        }
        // Allow access to login page if no token or invalid token
        return next();
    }

    // For all other routes
    if (!token) {
        return next({ name: "login" });
    }

    // Verify token validity for protected routes
    try {
        const isAuthenticated = await checkTokenAuthenticity();
        if (!isAuthenticated) {
            return next({ name: "login" });
        }
        next();
    } catch (error) {
        return next({ name: "login" });
    }
});

const checkTokenAuthenticity = async () => {
    try {
        const response = await axios.get("http://127.0.0.1:8000/api/user", {
            headers: {
                Authorization: `Bearer ${localStorage.getItem("token")}`,
            },
        });
        return true;
    } catch (error) {
        localStorage.removeItem("token");
        return false;
    }
};

export default router;
