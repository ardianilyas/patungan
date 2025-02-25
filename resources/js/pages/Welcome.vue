<script setup lang="ts">
import { Head } from '@inertiajs/vue3';
import Navbar from "@/components/Navbar.vue";
</script>

<template>
    <Head title="Home">
        <link rel="preconnect" href="https://rsms.me/" />
        <link rel="stylesheet" href="https://rsms.me/inter/inter.css" />
    </Head>
    <Navbar />
    <div class="mt-24 max-w-3xl mx-auto text-center p-6 text-[#1b1b18] dark:bg-[#0a0a0a] lg:p-8">
      <h1 class="text-6xl text-neutral-800 font-medium leading-tight">Boost Your Favorite Creator - Send a Tip !</h1>
      <p class="mt-6 text-lg leading-relaxed text-neutral-600">
        Love the content? Show your appreciation with a quick and easy donation! Our app lets you support your favorite streamer in just a few taps. Every contribution helps them create more of what you enjoy. Secure, fast, and built for fans like you – donate today and be part of the action!
      </p>
    </div>
</template>
