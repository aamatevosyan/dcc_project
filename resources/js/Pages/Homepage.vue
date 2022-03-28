<template>
    <app-layout title="Homepage">
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                    <main-landing />
                </div>
            </div>
        </div>
    </app-layout>
</template>

<script>
import {defineComponent} from 'vue'
import AppLayout from '@/Layouts/AppLayout.vue'
import MainLanding from '@/Jetstream/MainLanding.vue'

export default defineComponent({
        components: {
            AppLayout,
            MainLanding,
        },
    })
</script>
