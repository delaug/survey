require('./bootstrap');

import { createApp } from 'vue'
import App from './App.vue'
import router from './router'
import store from './store'
import components from './components/UI';

// UIkit
import UIkit from 'uikit';
import Icons from 'uikit/dist/js/uikit-icons';
// loads the Icon plugin
UIkit.use(Icons);

window.UIKit = UIkit

const app = createApp(App);

components.forEach(component => {
    app.component(component.name, component);
});

app.mixin({
    data: function () {
        return {
            get UIkit () {
                return UIkit
            }
        }
    }
});

app.use(store);
app.use(router);
app.mount('#app');
