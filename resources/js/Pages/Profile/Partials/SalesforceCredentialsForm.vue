<template>
    <jet-form-section @submitted="sendCredentialsData">
        <template #title>
            Application credentials form
        </template>

        <template #description>
            Input your credentials to .
        </template>

        <template #form>

            <!-- Correspondent Account -->
            <div class="col-span-6 sm:col-span-4">
                <jet-label for="correspondentAccount" value="Correspondent Account" />
                <jet-input id="correspondentAccount" type="text" class="mt-1 block w-full" v-model="form.correspondentAccount" autocomplete="" />
                <jet-input-error :message="form.errors.correspondentAccount" class="mt-2" />
            </div>

            <!-- BIC -->
            <div class="col-span-6 sm:col-span-4">
                <jet-label for="bic" value="BIC" />
                <jet-input id="bic" type="text" class="mt-1 block w-full" v-model="form.bic" autocomplete="" />
                <jet-input-error :message="form.errors.bic" class="mt-2" />
            </div>

            <!-- SNILS -->
            <div class="col-span-6 sm:col-span-4">
                <jet-label for="snils" value="SNILS" />
                <jet-input id="snils" type="text" class="mt-1 block w-full" v-model="form.snils" autocomplete="" />
                <jet-input-error :message="form.errors.snils" class="mt-2" />
            </div>

            <!-- Address -->
            <div class="col-span-6 sm:col-span-4">
                <jet-label for="address" value="Your address" />
                <jet-input id="address" type="select" class="mt-1 block w-full" v-model="form.address" autocomplete="" />
                <jet-input-error :message="form.errors.address" class="mt-2" />
            </div>

            <!-- Birth Date -->
            <div class="col-span-6 sm:col-span-4">
                <jet-label for="birthDate" value="Your birth date" />
                <jet-input id="birthDate" type="date" class="mt-1 block w-full" v-model="form.birthDate" autocomplete="" />
                <jet-input-error :message="form.errors.birthDate" class="mt-2" />
            </div>
        </template>

        <template #actions>
            <jet-action-message :on="form.recentlySuccessful" class="mr-3">
                Success
            </jet-action-message>

            <jet-button :class="{ 'opacity-25': form.processing }" class="bg-green-500 hover:bg-green-400" :disabled="form.processing">
                Send
            </jet-button>
        </template>
    </jet-form-section>
</template>

<script>
import {defineComponent} from 'vue'
import JetButton from '@/Jetstream/Button.vue'
import JetFormSection from '@/Jetstream/FormSection.vue'
import JetInput from '@/Jetstream/Input.vue'
import JetInputError from '@/Jetstream/InputError.vue'
import JetLabel from '@/Jetstream/Label.vue'
import JetActionMessage from '@/Jetstream/ActionMessage.vue'
import JetSecondaryButton from '@/Jetstream/SecondaryButton.vue'

export default defineComponent({
    components: {
        JetActionMessage,
        JetButton,
        JetFormSection,
        JetInput,
        JetInputError,
        JetLabel,
        JetSecondaryButton,
    },

    props: ['user'],

    data() {
        return {
            form: this.$inertia.form({
                _method: 'PUSH',
                correspondentAccount: null,
                bic: null,
                snils: null,
                address: null,
                birthDate: null,
            }),
        }
    },

    methods: {
        sendCredentialsData() {
            console.log(this.form);
            /*this.form.post(route('sf.courier.update'), {
                errorBag: 'updateProfileInformation',
                preserveScroll: true,
                onSuccess: () => null,
            });*/
        },
    },
})
</script>
