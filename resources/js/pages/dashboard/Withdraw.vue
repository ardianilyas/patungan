<template>
    <Head title="Withdraw" />
    <AppLayout>
        <template #title>Withdraw</template>
        <template #subtitle>You can withdraw your current balance here.</template>

        <p class="mt-3 font-medium inline-flex py-2 px-5 bg-blue-50 text-sm text-blue-600 rounded-md shadow-sm shadow-blue-100">Info : payment will be processed between 7.00 AM until 11.00 PM GMT+7. Otherwise it will be processed next day.</p>

        <div class="mt-4 max-w-3xl rounded-md bg-white p-6 shadow-md">
            <h4 class="text-lg text-neutral-800">
                Your current balance is : <b>{{ formatIDR(user.balance) }}</b>
            </h4>
            <form @submit.prevent="withdraw" class="mt-2 [&>div]:mb-4">
                <div>
                    <Label>Amount</Label>
                    <Input @input="calculateAfterTax" v-model="form.amount" placeholder="100000" />
                    <InputError v-if="form.errors.amount" :message="form.errors.amount" />
                    <p class="mt-2 text-sm text-neutral-600">You will receive : <b>Rp. {{ amountAfterTax }}</b></p>
                    <p></p>
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
import { ref } from "vue";

const { user } = useAuth();

const form = useForm<{
  amount: number | string
}>({
    amount: '',
});

const amount = ref<number|string>(0);
const tax = ref<number>(4000);
const amountAfterTax = ref<number>(0);

const calculateAfterTax = (): void => {
  amount.value = form.amount || 0;
  amountAfterTax.value = amount.value - tax.value;
  if (amountAfterTax.value < 0) {
    amountAfterTax.value = 0;
  }
}

function withdraw() {
    form.post(route('dashboard.withdraw.store'), {
        onSuccess: () => toast.success('Withdrawal being processed'),
        onError: (error) => {
            if (error.message) toast.error(error.message);
        }
    });
}
</script>