<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { type BreadcrumbItem } from '@/types';
import { Head } from '@inertiajs/vue3';
import { formatIDR } from '@/utils/currency'

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Dashboard',
        href: '/dashboard',
    },
];

defineProps<{
    name?: string;
    totalTransactions: number;
    totalUsers: number;
}>();
</script>

<template>
    <Head title="Dashboard" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="flex h-full flex-1 flex-col gap-4 rounded-xl p-4">
            <div class="grid auto-rows-min gap-4 md:grid-cols-2 lg:grid-cols-3">
                <div class="bg-white p-4 rounded-md shadow-md">
                    <h5 class="text-xl font-medium text-slate-800">Total transactions</h5>
                    <p class="font-medium">{{ formatIDR(totalTransactions) }}</p>
                </div>
                <div class="bg-white p-4 rounded-md shadow-md">
                    <h5 class="text-xl font-medium text-slate-800">Total users</h5>
                    <p class="font-medium">{{ totalUsers }}</p>
                </div>
            </div>
        </div>
    </AppLayout>
</template>
