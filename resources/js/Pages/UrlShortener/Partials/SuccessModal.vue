<script setup>
import Modal from "@/Components/Modal.vue";
import SecondaryButton from "@/Components/SecondaryButton.vue";
import TextInput from "@/Components/TextInput.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";

defineProps({
    url: {
        type: String,
    },
    urls: {
        type: Object,
    },
});

const copyToClipboard = (text) => {
    const el = document.createElement("textarea");
    el.value = text;
    document.body.appendChild(el);
    el.select();
    document.execCommand("copy");
    document.body.removeChild(el);
};

const openUrlInNewTab = (url) => {
    window.open(url, "_blank");
};
</script>

<template>
    <Modal
        :show="url != null ? true : false"
        @close="url = null"
        :closeable="true"
        maxWidth="lg"
    >
        <div class="p-6">
            <div class="flex items-center justify-center mb-5">
                <svg
                    class="w-16 h-16 text-green-500"
                    fill="none"
                    stroke="currentColor"
                    viewBox="0 0 24 24"
                    xmlns="http://www.w3.org/2000/svg"
                >
                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        stroke-width="2"
                        d="M5 13l4 4L19 7"
                    ></path>
                </svg>
            </div>

            <h2 class="text-lg text-gray-900 text-center mb-3 font-black">
                Congratulations! Your URL has been shortened!
            </h2>

            <p class="mt-1 text-sm text-gray-600 text-center max-w-md mx-auto">
                You can copy the url below and paste it in your browser to visit
                the website. or click the button below to open it in a new tab.
            </p>

            <div class="mt-6 flex justify-center">
                <TextInput
                    id="newUrl"
                    type="url"
                    class="mt-1 block w-3/4"
                    placeholder="url"
                    :modelValue="url"
                />
            </div>

            <div
                class="my-6 flex justify-center flex-col gap-4 items-center md:flex-row"
            >
                <SecondaryButton @click.prevent="copyToClipboard(url)">
                    Copy to clipboard
                </SecondaryButton>

                <PrimaryButton
                    class="md:\ml-3 ml-0"
                    @click.prevent="
                        try {
                            urls.data.find(
                                (u) => route('url.redirect', u.code) === url
                            ).clicks++;
                        } catch (error) {}

                        openUrlInNewTab(url);
                    "
                >
                    Open in new tab
                </PrimaryButton>
            </div>
        </div>
    </Modal>
</template>
