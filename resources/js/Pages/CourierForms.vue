<template>
    <app-layout title="Courier Forms">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Courier Forms
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto py-10 sm:px-6 lg:px-8">
                <div>
                    <salesforce-register-form :user="$page.props.user"/>

                    <jet-section-border/>
                </div>

                <div>
                    <salesforce-credentials-form :user="$page.props.user"/>

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

export default defineComponent({
    components: {
        AppLayout,
        Welcome,
        JetSectionBorder,
        SalesforceCredentialsForm,
        SalesforceRegisterForm,
    },
})
</script>
