require('./bootstrap');
import { createApp, h } from 'vue'
import { createInertiaApp, Head, Link } from '@inertiajs/inertia-vue3'
import BaseLayout from "./Pages/BaseLayout.vue"
import { InertiaProgress } from "@inertiajs/progress"
import Layout from "./Shared/Layout.vue"

InertiaProgress.init({
    showSpinner: true
});
createInertiaApp({
    resolve: name => {
        let page = require(`./Pages/${name}`).default;
        page.layout ??= page.layout = Layout;
        return page;
    },
    setup({ el, App, props, plugin }) {
        createApp({ render: () => h(App, props) })
            .use(plugin)
            .component("Link", Link)
            .component("base-layout", BaseLayout)
            .component("Head", Head)
            .mount(el)
    },
    title: (title) => title + " - My Inertia Test"
})