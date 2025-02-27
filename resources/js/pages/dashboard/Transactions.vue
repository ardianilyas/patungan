<template>
  <Head title="Transactions" />
  <AppLayout>
    <template #title>Transactions History</template>
    <template #subtitle>Below you can see your transactions history</template>

    <div class="my-8">
      <div class="my-8" v-for="(group, date) in transactions" :key="date">
        <h4 class="mb-2 text-lg font-medium text-neutral-800">{{ date }}</h4>
        <div class="mb-3 w-full  flex items-center gap-6" v-for="transaction in group" :key="transaction">
          <div class="inline-flex justify-center items-center font-bold p-2 w-10 h-10 rounded-md shadow-sm" :class="transaction.type === 'topup' ? 'bg-green-300  text-green-600' : 'bg-blue-300 text-blue-600'">
            {{ transaction.type === 'topup' ? "T" : "D" }}
          </div>
          <div>
            <h4 class="text-neutral-800 font-medium">{{ transaction.id }}</h4>
            <p class="text-xs text-neutral-500">{{ transaction.payment_method }}</p>
          </div>
        </div>
      </div>
    </div>
  </AppLayout>
</template>

<script setup lang="ts">
import AppLayout from "@/layouts/AppLayout.vue";
import { Head } from '@inertiajs/vue3';

defineProps({
  transactions: Object,
});
</script>