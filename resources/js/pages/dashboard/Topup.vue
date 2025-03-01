<template>
  <Head title="Topup" />
  <AppLayout>
    <template #title>Topup History</template>
    <template #subtitle>Below you can see your topup history</template>

    <div class="mt-6 bg-white shadow-md rounded-md p-4">
      <Table>
        <TableHeader>
          <TableRow>
            <TableHead>No.</TableHead>
            <TableHead>ID</TableHead>
            <TableHead>External ID</TableHead>
            <TableHead>Amount</TableHead>
            <TableHead>Status</TableHead>
            <TableHead>Date</TableHead>
          </TableRow>
        </TableHeader>
        <TableBody>
          <TableRow v-for="(topup, index) in topups" :key="topup">
            <TableCell>{{ index + 1 }}</TableCell>
            <TableCell>{{ topup.id }}</TableCell>
            <TableCell>
              {{ topup.external_id }}
            </TableCell>
            <TableCell>
              <b>{{ formatIDR(topup.amount) }}</b>
            </TableCell>
            <TableCell>
              <span v-if="topup.status === 'success' || topup.status === 'paid' " class="text-green-600 bg-green-100 rounded-full py-1 px-4">{{ topup.status }}</span>
              <span v-if="topup.status === 'failed' " class="text-red-600 bg-red-100 rounded-full py-1 px-4">{{ topup.status }}</span>
              <span v-if="topup.status === 'pending' " class="text-yellow-600 bg-yellow-100 rounded-full py-1 px-4">{{ topup.status }}</span>
            </TableCell>
            <TableCell>
              <b>{{ topup.created_at }}</b>
            </TableCell>
          </TableRow>
        </TableBody>
      </Table>
    </div>
  </AppLayout>
</template>

<script setup lang="ts">
import { Head } from '@inertiajs/vue3'
import AppLayout from "@/layouts/AppLayout.vue";
import { formatIDR } from "@/utils/currency";
import {Table, TableBody, TableCell, TableHead, TableHeader, TableRow} from "@/components/ui/table";

defineProps({
  topups: Object,
});
</script>