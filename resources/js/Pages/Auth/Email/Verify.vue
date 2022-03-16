<template>
    <Head title="Verify"/>

    <jet-authentication-card>
        <template #logo>
            <jet-authentication-card-logo/>
        </template>

        <h1 class="font-bold">Step 1: Email Verification</h1>

        <jet-validation-errors class="mb-4"/>

        <p>An email with code was just sent to {{ $attrs.email }}</p>
        <form @submit.prevent="submit">
            <div class="mt-4">
                <jet-label for="code" value="Enter code"/>
                <jet-input id="code" type="number" class="mt-1 block w-full" v-model="form.code" required/>
            </div>

            <div class="flex items-center justify-end mt-4">
                <jet-button class="ml-4" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                    Verify
                </jet-button>
            </div>
        </form>
    </jet-authentication-card>
</template>

<script>
import {defineComponent} from 'vue'
import JetAuthenticationCard from '@/Jetstream/AuthenticationCard.vue'
import JetAuthenticationCardLogo from '@/Jetstream/AuthenticationCardLogo.vue'
import JetButton from '@/Jetstream/Button.vue'
import JetInput from '@/Jetstream/Input.vue'
import JetLabel from '@/Jetstream/Label.vue'
import JetValidationErrors from '@/Jetstream/ValidationErrors.vue'
import {Head, Link} from '@inertiajs/inertia-vue3';

export default defineComponent({
    components: {
        Head,
        JetAuthenticationCard,
        JetAuthenticationCardLogo,
        JetButton,
        JetInput,
        JetLabel,
        JetValidationErrors,
        Link,
    },

    data() {
        return {
            form: this.$inertia.form({
                code: ''
            })
        }
    },

    methods: {
        submit() {
            this.form.delete(
                this.route('auth.register.email.validate.destroy', {
                    uuid: this.$attrs.uuid
                })
            )
        }
    }
})
</script>
