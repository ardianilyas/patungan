<template>
  <Navbar />
  <div class="mt-24 max-w-3xl mx-auto p-6 text-[#1b1b18] dark:bg-[#0a0a0a] lg:p-8">
    <slot />
  </div>
</template>

<script setup lang="ts">

import Navbar from "@/components/Navbar.vue";
</script>