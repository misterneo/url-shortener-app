<script setup>
import InputError from "@/Components/InputError.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import ReloadButton from "@/Components/ReloadButton.vue";
import TextInput from "@/Components/TextInput.vue";
import { Head, useForm } from "@inertiajs/vue3";
import ApplicationLogo from "@/Components/ApplicationLogo.vue";
import SuccessModal from "./Partials/SuccessModal.vue";
import UrlsTable from "./Partials/UrlsTable.vue";

defineProps({
    urls: {
        type: Object,
    },
    url: {
        type: String,
    },
});

const form = useForm({
    url: "",
});

const submit = () => {
    form.post(route("url.shorten"), {
        onSuccess: () => {
            form.reset("url");
        },
    });
};
</script>

<template>
    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
        <Head title="Home" />

        <ApplicationLogo />

        <form
            @submit.prevent="submit"
            class="md:w-1/2 w-full md:mx-auto px-5 mb-5"
        >
            <div>
                <TextInput
                    id="url"
                    type="url"
                    class="mt-1 block w-full"
                    v-model="form.url"
                    required
                    placeholder="Enter your long url here"
                />

                <InputError class="mt-2" :message="form.errors.url" />
            </div>

            <div class="flex items-center justify-center mt-4">
                <PrimaryButton
                    class="w-full justify-center"
                    :class="{ 'opacity-25': form.processing }"
                    :disabled="form.processing"
                >
                    Shorten
                </PrimaryButton>
            </div>
        </form>

        <div class="my-6">
            <hr />
        </div>

        <div class="px-2">
            <div class="flex justify-between items-center my-5 px-2">
                <h2 class="font-semibold">Shortened URLs</h2>

                <ReloadButton />
            </div>

            <UrlsTable :urls="urls" />
        </div>
    </div>

    <SuccessModal :url="url" :urls="urls" />
</template>
