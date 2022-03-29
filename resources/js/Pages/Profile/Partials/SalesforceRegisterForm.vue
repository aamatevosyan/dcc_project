<template>
    <jet-form-section @submitted="sendRegisterData">
        <template #title>
            Make an application
        </template>

        <template #description>
            Update your account's profile information and email address.
        </template>

        <template #form>

            <!-- Citizenship -->
            <div class="col-span-6 sm:col-span-4">
                <jet-label for="citizenship" value="Citizenship"/>
                <select id="citizenship"
                        class="border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm mt-1 block w-full"
                        v-model="form.citizenship" required>
                    <option class="mt-1 block w-full" disabled value="">Choose citizenship</option>
                    <option class="mt-1 block w-full">Russian</option>
                    <option class="mt-1 block w-full">Belorussian</option>
                    <option class="mt-1 block w-full">NIS</option>
                    <option class="mt-1 block w-full">Kazakhstanian</option>
                </select>
                <jet-input-error :message="form.errors.citizenship" class="mt-2"/>
            </div>

            <!-- INN -->
            <div class="col-span-6 sm:col-span-4">
                <jet-label for="inn" value="INN"/>
                <jet-input id="inn" type="text" class="mt-1 block w-full" v-model="form.inn" required
                           autocomplete="0123456789"/>
                <jet-input-error :message="form.errors.inn" class="mt-2"/>
            </div>

            <!-- Passport Code -->
            <div class="col-span-6 sm:col-span-4">
                <jet-label for="passportCode" value="Passport code"/>
                <jet-input id="passportCode" type="text" class="mt-1 block w-full" v-model="form.passportCode" required
                           autocomplete="0000"/>
                <jet-input-error :message="form.errors.passportCode" class="mt-2"/>
            </div>

            <!-- Passport Number -->
            <div class="col-span-6 sm:col-span-4">
                <jet-label for="passportNum" value="Passport number"/>
                <jet-input id="passportNum" type="text" class="mt-1 block w-full" v-model="form.passportNum" required
                           autocomplete="000000"/>
                <jet-input-error :message="form.errors.passportNum" class="mt-2"/>
            </div>
        </template>

        <template #actions>
            <jet-action-message :on="form.recentlySuccessful" class="mr-3">
                Success
            </jet-action-message>

            <jet-button :class="{ 'opacity-25': form.processing }" class="bg-green-500 hover:bg-green-400"
                        :disabled="form.processing">
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
                inn: null,
                citizenship: null,
                passportCode: null,
                passportNum: null,
            }),
        }
    },

    methods: {
        sendRegisterData() {
            console.log(this.form);
            this.form.post(this.route('sf.courier.create'), {
                preserveScroll: true,
                onSuccess: () => null,
            });
        },
    },
})
</script>
