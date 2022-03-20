<template>
    <Head title="Finalize"/>

    <jet-authentication-card>
        <template #logo>
            <jet-authentication-card-logo/>
        </template>

        <h1 class="font-bold mb-4">Step 3: Finalize Registration</h1>

        <jet-validation-errors class="mb-4"/>

        <form @submit.prevent="submit">
            <div class="mt-4">
                <jet-label for="first_name" value="First Name"/>
                <jet-input id="first_name" type="text" class="mt-1 block w-full" v-model="form.first_name" required
                           autofocus autocomplete="first_name"/>
            </div>

            <div class="mt-4">
                <jet-label for="last_name" value="Last Name"/>
                <jet-input id="last_name" type="text" class="mt-1 block w-full" v-model="form.last_name" required
                           autofocus autocomplete="last_name"/>
            </div>

            <div class="mt-4">
                <jet-label for="password" value="Password"/>
                <jet-input id="password" type="password" class="mt-1 block w-full" v-model="form.password" required
                           autocomplete="new-password"/>
            </div>

            <div class="mt-4">
                <jet-label for="password_confirmation" value="Confirm Password"/>
                <jet-input id="password_confirmation" type="password" class="mt-1 block w-full"
                           v-model="form.password_confirmation" required autocomplete="new-password"/>
            </div>

            <div class="flex items-center justify-end mt-4">
                <jet-button class="ml-4" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                    Register
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
import JetCheckbox from '@/Jetstream/Checkbox.vue'
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
        JetCheckbox,
        JetLabel,
        JetValidationErrors,
        Link,
    },

    data() {
        return {
            form: this.$inertia.form({
                first_name: '',
                last_name: '',
                password: '',
                password_confirmation: ''
            })
        }
    },

    methods: {
        submit() {
            this.form.post(this.route('auth.register.finalize.store', {
                user: this.$attrs.uuid
            }), {
                onFinish: () => this.form.reset('password', 'password_confirmation'),
            })
        }
    }
})
</script>
