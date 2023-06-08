<script setup>
import Pagination from "@/Components/Pagination.vue";

defineProps({
    urls: {
        type: Object,
    },
});

const openUrlInNewTab = (url) => {
    window.open(url, "_blank");
};
</script>

<template>
    <div class="relative overflow-x-auto">
        <table class="w-full text-sm text-left text-gray-500">
            <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                <tr>
                    <th scope="col" class="px-6 py-3">Short Url</th>
                    <th scope="col" class="px-6 py-3 text-center">Clicks</th>
                    <th scope="col" class="px-6 py-3">Long Url</th>
                </tr>
            </thead>
            <tbody>
                <tr
                    class="bg-white border-b"
                    v-for="url in urls.data"
                    :key="url.id"
                >
                    <th class="px-6 py-4 text-sm text-gray-500 font-bold">
                        <a
                            :href="route('url.redirect', url.code)"
                            target="_blank"
                            class="text-blue-500 hover:text-blue-700"
                            @click.prevent="
                                url.clicks++;
                                openUrlInNewTab(
                                    route('url.redirect', url.code)
                                );
                            "
                        >
                            {{ route("url.redirect", url.code) }}</a
                        >
                    </th>
                    <td class="px-6 py-4 text-sm text-gray-500 text-center">
                        {{ url.clicks }}
                    </td>

                    <td
                        scope="row"
                        class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap"
                    >
                        {{ url.url }}
                    </td>
                </tr>
            </tbody>
        </table>
        <div class="flex justify-center my-10">
            <Pagination
                :links="urls.links"
                :classes="{
                    'justify-between': true,
                    'mt-4': true,
                    flex: true,
                }"
            />
        </div>
    </div>
</template>
