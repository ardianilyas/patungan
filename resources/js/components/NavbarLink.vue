<template>
  <Link :href="href" class="flex hover:text-blue-600" :class="isActive ? 'text-blue-600' : 'text-neutral-800' ">
    <slot />
  </Link>
</template>

<script setup lang="ts">
import { Link } from '@inertiajs/vue3';

defineProps({
  href: {
    required: true,
    type: String
  },
  isActive: {
    required: true,
    type: Boolean
  }
})
</script>