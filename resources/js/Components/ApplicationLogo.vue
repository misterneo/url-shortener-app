<script setup>
import { Link } from "@inertiajs/vue3";
</script>

<template>
    <div class="flex flex-col justify-center items-center my-5 gap-1">
        <Link href="/">
            <svg
                class="w-20 h-20 text-green-500"
                fill="none"
                stroke="currentColor"
                viewBox="0 0 24 24"
                xmlns="http://www.w3.org/2000/svg"
            >
                <path
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    stroke-width="1.5"
                    d="M13 10V3L4 14h7v7l9-11h-7z"
                ></path>
            </svg>
        </Link>
        <h1 class="text-center text-2xl font-black">URL Shortener</h1>
    </div>
</template>
