require('./bootstrap');

import { createApp, h } from 'vue';
import Lang from 'lang.js';
import { createInertiaApp } from '@inertiajs/inertia-vue3';
import { InertiaProgress } from '@inertiajs/progress';

const appName = window.document.getElementsByTagName('title')[0]?.innerText || 'Laravel';

//  TODO: Я пытался локаль настроить в vue как в laravel, пока забил https://github.com/kg-bot/laravel-localization-to-vue
// const default_locale = window.default_locale;
// const fallback_locale = window.fallback_locale;
// const messages = window.messages;
// const trans = new Lang( { messages, locale: default_locale, fallback: fallback_locale });

createInertiaApp({
    title: (title) => `${title} - ${appName}`,
    resolve: (name) => require(`./Pages/${name}.vue`),
    setup({ el, app, props, plugin }) {
        return createApp({ render: () => h(app, props) })
            .use(plugin)
            .mixin({ methods: { route } })
            .mount(el);
    },
});

InertiaProgress.init({ color: '#4B5563' });
