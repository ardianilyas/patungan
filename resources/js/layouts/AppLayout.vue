<script setup lang="ts">
import AppLayout from '@/layouts/app/AppSidebarLayout.vue';
import type { BreadcrumbItemType } from '@/types';
import { Toaster } from "vue-sonner";

interface Props {
    breadcrumbs?: BreadcrumbItemType[];
}

withDefaults(defineProps<Props>(), {
    breadcrumbs: () => [],
});
</script>

<template>
  <Toaster rich-colors position="top-center" close-button />
    <AppLayout :breadcrumbs="breadcrumbs">
        <h3 class="text-2xl text-neutral-800 font-medium">
          <slot name="title" />
        </h3>
        <p class="text-neutral-600 leading-relaxed">
          <slot name="subtitle" />
        </p>
        <slot />
    </AppLayout>
</template>
