<template>
    <Head title="Welcome"/>

    <div
        class="relative flex items-top justify-center min-h-screen bg-gray-100 dark:bg-gray-900 sm:items-center sm:pt-0">
        <div v-if="canLogin">
            <div v-if="$page.props.user" class="p-10 lg:flex lg:items-center lg:justify-between">
                <div class="flex-1 min-w-0">
                    <p class="text-2xl font-bold leading-7 text-gray-900 sm:text-3xl selection:bg-fuchsia-300 select-none">
                        Delivery Club Courier Platform
                    </p>
                </div>
                <div class="mt-5 flex lg:mt-0 lg:ml-6">
                    <div class="mr-3 inline-flex rounded-md shadow text-white bg-green-500 hover:bg-green-600">
                        <Link :href="route('homepage')"
                              class="px-8 py-4 font-bold text-center rounded-md select-none">
                            Homepage
                        </Link>
                    </div>

                    <div class="ml-3 text-green-600 bg-white hover:bg-green-50 inline-flex rounded-md shadow">
                        <Link v-if="$page.props.user" :href="route('forms')"
                              class="px-8 py-4 font-bold text-center rounded-md select-none">
                            Courier Forms
                        </Link>
                    </div>
                </div>
            </div>

            <template v-else>
                <div class="p-10 lg:flex lg:items-center lg:justify-between">
                    <div class="flex-1 min-w-0">
                        <p class="text-2xl font-bold leading-7 text-gray-900 sm:text-3xl selection:bg-fuchsia-300 select-none">
                            Delivery Club Courier Platform
                        </p>
                    </div>
                    <div class="mt-5 flex lg:mt-0 lg:ml-6">
                        <div class="mr-3 inline-flex rounded-md shadow text-white bg-green-500 hover:bg-green-600">
                            <Link :href="route('login')"
                                  class="px-8 py-4 font-bold text-center rounded-md select-none">
                                Log in
                            </Link>
                        </div>


                        <div class="ml-3 text-green-600 bg-white hover:bg-green-50 inline-flex rounded-md shadow">
                            <Link v-if="canRegister" :href="route('auth.register.email.create')"
                                  class="px-8 py-4 font-bold text-center rounded-md select-none">
                                Register
                            </Link>
                        </div>
                    </div>
                </div>
            </template>
        </div>
    </div>
</template>

<style scoped>
.bg-gray-100 {
    background-color: #f7fafc;
    background-color: rgba(247, 250, 252, var(--tw-bg-opacity));
}

.border-gray-200 {
    border-color: #edf2f7;
    border-color: rgba(237, 242, 247, var(--tw-border-opacity));
}

.text-gray-400 {
    color: #cbd5e0;
    color: rgba(203, 213, 224, var(--tw-text-opacity));
}

.text-gray-500 {
    color: #a0aec0;
    color: rgba(160, 174, 192, var(--tw-text-opacity));
}

.text-gray-600 {
    color: #718096;
    color: rgba(113, 128, 150, var(--tw-text-opacity));
}

.text-gray-700 {
    color: #4a5568;
    color: rgba(74, 85, 104, var(--tw-text-opacity));
}

.text-gray-900 {
    color: #1a202c;
    color: rgba(26, 32, 44, var(--tw-text-opacity));
}

@media (prefers-color-scheme: dark) {
    .dark\:bg-gray-800 {
        background-color: #2d3748;
        background-color: rgba(45, 55, 72, var(--tw-bg-opacity));
    }

    .dark\:bg-gray-900 {
        background-color: #1a202c;
        background-color: rgba(26, 32, 44, var(--tw-bg-opacity));
    }

    .dark\:border-gray-700 {
        border-color: #4a5568;
        border-color: rgba(74, 85, 104, var(--tw-border-opacity));
    }

    .dark\:text-white {
        color: #fff;
        color: rgba(255, 255, 255, var(--tw-text-opacity));
    }

    .dark\:text-gray-400 {
        color: #cbd5e0;
        color: rgba(203, 213, 224, var(--tw-text-opacity));
    }
}
</style>

<script>
import {defineComponent} from 'vue'
import {Head, Link} from '@inertiajs/inertia-vue3'
import JetAuthenticationCardLogo from "@/Jetstream/AuthenticationCardLogo"

export default defineComponent({
    components: {
        Head,
        Link,
        JetAuthenticationCardLogo
    },

    props: {
        canLogin: Boolean,
        canRegister: Boolean,
        laravelVersion: String,
        phpVersion: String,
    }
})
</script>
