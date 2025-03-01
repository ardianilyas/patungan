<template>
  <Head title="Transactions" />
  <AppLayout>
    <template #title>Transactions History</template>
    <template #subtitle>Below you can see your transactions history</template>

    <div class="mt-4 bg-white shadow-md rounded-md p-4">
      <Table>
        <TableHeader>
          <TableRow>
            <TableHead>No.</TableHead>
            <TableHead>ID</TableHead>
            <TableHead>Type</TableHead>
            <TableHead>Amount</TableHead>
            <TableHead>Status</TableHead>
            <TableHead>Payment Method</TableHead>
            <TableHead>Payment Channel</TableHead>
            <TableHead>Date</TableHead>
          </TableRow>
        </TableHeader>
        <TableBody>
          <TableRow v-for="(transaction, index) in transactions" :key="transaction">
            <TableCell>{{ index + 1 }}</TableCell>
            <TableCell>{{ transaction.id }}</TableCell>
            <TableCell class="capitalize">
              <span v-if="transaction.type === 'topup' " class="text-violet-600 bg-violet-100 py-1 px-4 rounded-full">{{ transaction.type }}</span>
              <span v-if="transaction.type === 'withdraw' " class="text-sky-600 bg-sky-100 py-1 px-4 rounded-full">{{ transaction.type }}</span>
              <span v-if="transaction.type === 'donation' " class="text-pink-600 bg-pink-100 py-1 px-4 rounded-full">{{ transaction.type }}</span>
            </TableCell>
            <TableCell>
              <b>{{ formatIDR(transaction.amount) }}</b>
            </TableCell>
            <TableCell class="lowercase">
              <span v-if="transaction.status === 'success' || transaction.status === 'paid' || transaction.status === 'SUCCEEDED' " class="text-green-600 bg-green-100 py-1 px-4 rounded-full">{{ transaction.status }}</span>
              <span v-if="transaction.status === 'failed' " class="text-red-600 bg-red-100 py-1 px-4 rounded-full">{{ transaction.status }}</span>
              <span v-if="transaction.status === 'pending' " class="text-yellow-600 bg-yellow-100 py-1 px-4 rounded-full">{{ transaction.status }}</span>
            </TableCell>
            <TableCell class="lowercase">{{ transaction.payment_method }}</TableCell>
            <TableCell>{{ transaction.payment_channel }}</TableCell>
            <TableCell>{{ transaction.created_at }}</TableCell>
          </TableRow>
        </TableBody>
      </Table>
    </div>

<!--    <div class="my-8">-->
<!--      <div class="my-8" v-for="(group, date) in transactions" :key="date">-->
<!--        <h4 class="mb-2 text-lg font-medium text-neutral-800">{{ date }}</h4>-->
<!--        <div class="mb-3 p-4 bg-neutral-50 shadow-md rounded-md max-w-2xl w-full inline-flex items-center gap-6" v-for="transaction in group" :key="transaction">-->
<!--          <div class=" font-bold">-->
<!--            <span class="inline-flex justify-center items-center bg-green-200 text-green-600 p-2 w-10 h-10 rounded-md shadow-sm" v-if="transaction.type === 'topup'">T</span>-->
<!--            <span class="inline-flex justify-center items-center bg-blue-200 text-blue-600 p-2 w-10 h-10 rounded-md shadow-sm" v-if="transaction.type === 'donation'">D</span>-->
<!--            <span class="inline-flex justify-center items-center bg-violet-200 text-violet-600 p-2 w-10 h-10 rounded-md shadow-sm" v-if="transaction.type === 'withdraw'">W</span>-->
<!--          </div>-->
<!--          <div>-->
<!--            <p class="font-medium">-->
<!--              <span class="text-sm px-3 rounded-full bg-green-200 text-green-600" v-if="transaction.status === 'success' || transaction.status === 'SUCCEEDED' ">success</span>-->
<!--              <span class="text-sm px-3 rounded-full bg-yellow-200 text-yellow-600" v-if="transaction.status === 'pending' ">pending</span>-->
<!--              <span class="text-sm px-3 rounded-full bg-red-200 text-red-600" v-if="transaction.status === 'failed' || transaction.status === 'FAILED' ">failed</span>-->
<!--            </p>-->
<!--            <h4 class="text-neutral-800 font-medium">{{ transaction.id }}</h4>-->
<!--            <p class="text-sm font-medium text-neutral-500">{{ formatIDR(transaction.amount) }}</p>-->
<!--          </div>-->
<!--        </div>-->
<!--      </div>-->
<!--    </div>-->
  </AppLayout>
</template>

<script setup lang="ts">
import AppLayout from "@/layouts/AppLayout.vue";
import { Head } from '@inertiajs/vue3';
import { formatIDR } from "@/utils/currency";
import {Table, TableBody, TableCell, TableHead, TableHeader, TableRow} from "@/components/ui/table";

defineProps({
  transactions: Object,
});
</script>