<template>
  <Head title="Topup" />
  <AppLayout>
    <template #title>Topup History</template>
    <template #subtitle>Below you can see your topup history</template>

    <div class="my-8 grid grid-cols-1 sm:grid-cols-2 gap-6">
      <div v-for="topup in topups" :key="topup" class="bg-white p-4 rounded-md shadow-md">
        <h4 class="font-medium text-neutral-800"> Topup id : {{ topup.id }}</h4>
        <h4 class="font-medium text-neutral-800"> External id : {{ topup.external_id }}</h4>
        <h4 class="font-medium text-neutral-800"> Amount : {{ formatIDR(topup.amount) }}</h4>
        <h4 class="font-medium text-neutral-800"> Paid at : {{ topup.paid_at }}</h4>
        <h4 class="font-medium text-neutral-800">
          Status :
          <span v-if="topup.status === 'paid'" class="text-green-600">{{ topup.status }}</span>
          <span v-if="topup.status === 'failed'" class="text-red-500">{{ topup.status }}</span>
          <span v-if="topup.status === 'pending'" class="text-yellow-400">{{ topup.status }}</span>
        </h4>
      </div>
    </div>
  </AppLayout>
</template>

<script setup lang="ts">
import { Head } from '@inertiajs/vue3'
import AppLayout from "@/layouts/AppLayout.vue";
import { formatIDR } from "@/utils/currency";

defineProps({
  topups: Object,
});
</script>