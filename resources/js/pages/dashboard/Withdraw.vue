<template>
    <Head title="Withdraw" />
    <AppLayout>
        <template #title>Withdraw</template>
        <template #subtitle>You can withdraw your current balance here.</template>

        <p class="inline-flex py-2 px-5 bg-blue-200 text-sm text-blue-700 rounded-md shadow-sm shadow-blue-100">Info : payment will be processed between 7.00 AM until 11.00 PM. Otherwise it will be processed next day</p>

        <div class="mt-6 max-w-3xl rounded-md bg-white p-6 shadow-md">
            <h4 class="text-lg text-neutral-800">
                Your current balance is : <b>{{ formatIDR(user.balance) }}</b>
            </h4>
            <form @submit.prevent="withdraw" class="mt-2 [&>div]:mb-4">
                <div>
                    <Label>Amount</Label>
                    <Input v-model="form.amount" placeholder="100000" />
                    <InputError v-if="form.errors.amount" :message="form.errors.amount" />
                    <p class="text-sm text-neutral-600">Note that the tax is Rp. 4000</p>
                </div>
                <div>
                    <Button type="submit" :disabled="form.processing">Withdraw</Button>
                </div>

            </form>
        </div>
    </AppLayout>
</template>

<script setup lang="ts">
import { Head, useForm } from '@inertiajs/vue3';
import AppLayout from '@/layouts/AppLayout.vue';
import { useAuth } from '@/composables/useAuth';
import { formatIDR } from '@/utils/currency';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import { Button } from '@/components/ui/button';
import InputError from '@/components/InputError.vue';
import { toast } from 'vue-sonner';
import {ref} from "vue";

const { user } = useAuth();

const form = useForm({
    amount: '',
});

function withdraw() {
    form.post(route('dashboard.withdraw.store'), {
        onSuccess: () => toast.success('Withdrawal being processed'),
        onError: (error) => {
            if (error.message) toast.error(error.message);
        }
    });
}
</script>