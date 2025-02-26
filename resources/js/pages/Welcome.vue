<script setup lang="ts">
import { Head } from '@inertiajs/vue3';
import MainLayout from "@/layouts/MainLayout.vue";
</script>

<template>
    <Head title="Home">
        <link rel="preconnect" href="https://rsms.me/" />
        <link rel="stylesheet" href="https://rsms.me/inter/inter.css" />
    </Head>
    <MainLayout>
      <h1 class="text-4xl text-center lg:text-7xl text-neutral-800 font-semibold leading-tight">Boost Your Favorite Creator Mood, Send a Tip Now !</h1>
      <p class="mt-6 text-base text-center lg:text-lg leading-relaxed text-neutral-600">
        Love the content? Show your appreciation with a quick and easy donation! Our app lets you support your favorite streamer in just a few taps. Every contribution helps them create more of what you enjoy. Secure, fast, and built for fans like you – donate today and be part of the action!
      </p>
    </MainLayout>
</template>
