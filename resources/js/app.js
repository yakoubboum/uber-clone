// filepath: /c:/Users/user/Desktop/uber-clone/resources/js/app.js
import './bootstrap';
import { createApp } from 'vue';
import router from './router';
import ExampleComponent from './components/ExampleComponent.vue';

const app = createApp({});

app.component('example-component', ExampleComponent);

app.use(router);

app.mount('#app');
