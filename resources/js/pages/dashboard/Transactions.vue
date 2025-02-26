<template>
  <AppLayout>
    <template #title>Transactions History</template>
    <template #subtitle>Below you can see your transactions history</template>

    <div class="my-8 grid grid-cols-1 sm:grid-cols-2 gap-6">
      <div v-for="transaction in transactions" :key="transaction" class="bg-white p-4 shadow-md rounded-md">
        <h4 class="font-medium text-neutral-800"> Transaction id : {{ transaction.id }}</h4>
        <h4 class="font-medium text-neutral-800"> Transaction type : {{ transaction.type }}</h4>
        <h4 class="font-medium text-neutral-800"> Transaction status : {{ transaction.status }}</h4>
        <h4 class="font-medium text-neutral-800"> Payment method : {{ transaction.payment_method }}</h4>
        <h4 class="font-medium text-neutral-800"> Payment channel : {{ transaction.payment_channel }}</h4>
        <h4 class="font-medium text-neutral-800"> Paid at : {{ transaction.paid_at }}</h4>
      </div>
    </div>
  </AppLayout>
</template>

<script setup lang="ts">
import AppLayout from "@/layouts/AppLayout.vue";

defineProps({
  transactions: Object,
});
</script>