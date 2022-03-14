<template>
    <Head title="Register"/>

    <jet-authentication-card>
        <template #logo>
            <jet-authentication-card-logo/>
        </template>

        <jet-validation-errors class="mb-4"/>

        <h1 class="font-bold">Step 2: Phone Verification</h1>
        <form @submit.prevent="submit">
            <div class="mt-4">
                <jet-label for="phone" value="Phone"/>
                <jet-input id="phone" type="tel" class="mt-1 block w-full" v-model="form.phone" required/>
            </div>

            <div class="flex items-center justify-end mt-4">
                <jet-button class="ml-4" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                    Continue
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
                phone: ''
            })
        }
    },

    methods: {
        submit() {
            console.log(this.$attrs.user)
            this.form.post(this.route('auth.register.phone.store', {
                    user: this.$attrs.user
                })
            )
        }
    }
})
</script>
