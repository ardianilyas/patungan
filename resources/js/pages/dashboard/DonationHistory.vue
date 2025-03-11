<template>
    <Head title="Donation History" />
    <AppLayout>
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
            <div v-for="donation in donations" :key="donation" class="bg-white min-h-20 p-4 shadow-md rounded-md">
                <h4 class="font-medium text-xl text-slate-800"> {{ donation.sender.name }} </h4>
                <p class="text-slate-600"> {{ formatIDR(donation.amount) }} </p>
            </div>
        </div>
    </AppLayout>
</template>

<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue'
import { Head } from '@inertiajs/vue3'
import { formatIDR } from '@/utils/currency'

defineProps({
    donations: Object
});
</script>