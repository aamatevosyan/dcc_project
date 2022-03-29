<template>
    <app-layout title="Courier Forms">
        <template #header>
            <div class="flex justify-between">
                <div class="shrink-0 flex items-center mr-4">
                    {{ $attrs.request_status }}
                </div>
                <form method="GET" @submit.prevent="refreshStatus">
                    <jet-button class="bg-green-500 hover:bg-green-400">
                        Refresh Request Status
                    </jet-button>
                </form>
            </div>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto py-10 sm:px-6 lg:px-8">

                <div>
                    <salesforce-register-form :data="this.$attrs.law_registration?.data?.body"/>

                    <jet-section-border/>
                </div>

                <div>
                    <salesforce-credentials-form :data="this.$attrs.payment_account?.data?.body"/>

                    <jet-section-border/>
                </div>
            </div>
        </div>
    </app-layout>
</template>

<script>
import {defineComponent} from 'vue'
import AppLayout from '@/Layouts/AppLayout.vue'
import Welcome from '@/Jetstream/Welcome.vue'
import SalesforceRegisterForm from "@/Pages/Profile/Partials/SalesforceRegisterForm";
import SalesforceCredentialsForm from "@/Pages/Profile/Partials/SalesforceCredentialsForm"
import JetSectionBorder from "@/Jetstream/SectionBorder";
import JetButton from "@/Jetstream/Button";

export default defineComponent({
    components: {
        AppLayout,
        Welcome,
        JetSectionBorder,
        JetButton,
        SalesforceCredentialsForm,
        SalesforceRegisterForm,
    },

    methods: {
        refreshStatus() {
            this.$inertia.get(route('sf.courier.check'))
        }
    }
})
</script>
