<template>
    <Head title="Withdraw" />
    <AppLayout>
        <template #title>Withdraw</template>
        <template #subtitle>You can withdraw your current balance here.</template>

        <p class="max-w-3xl w-full mt-3 font-medium py-2 px-5 bg-blue-50 text-sm text-blue-600 rounded-md shadow-sm shadow-blue-100">Info : payment will be processed between 7.00 AM until 11.00 PM GMT+7. Otherwise it will be processed next day.</p>

        <p class="max-w-3xl w-full mt-3 font-medium py-2 px-5 bg-yellow-50 text-sm text-yellow-600 rounded-md shadow-sm shadow-yellow-100" v-if="!isHaveBankAccount">Warning : please fill your bank account on
          <Link class="underline underline-offset-4" :href="route('dashboard.bank-account.index')"> bank account </Link>
          first to continue withdrawal process
        </p>

        <div class="mt-4 max-w-3xl rounded-md bg-white p-6 shadow-md">
            <h4 class="text-lg text-neutral-800">
                Your current balance is : <b>{{ formatIDR(user.balance) }}</b>
            </h4>
            <form @submit.prevent="withdraw" class="mt-2 [&>div]:mb-4">
                <div>
                    <Label>Amount</Label>
                    <Input :disabled="!isHaveBankAccount" @input="calculateAfterTax" v-model="form.amount" placeholder="100000" />
                    <InputError v-if="form.errors.amount" :message="form.errors.amount" />
                    <p class="mt-2 text-sm text-neutral-600">You will receive : <b>Rp. {{ amountAfterTax }}</b></p>
                    <p></p>
                </div>
                <div>
                    <Button type="submit" :disabled="form.processing || !isHaveBankAccount">Withdraw</Button>
                </div>
            </form>
        </div>
    </AppLayout>
</template>

<script setup lang="ts">
import { Head, useForm, Link } from '@inertiajs/vue3';
import AppLayout from '@/layouts/AppLayout.vue';
import { useAuth } from '@/composables/useAuth';
import { formatIDR } from '@/utils/currency';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import { Button } from '@/components/ui/button';
import InputError from '@/components/InputError.vue';
import { toast } from 'vue-sonner';
import { ref } from "vue";

defineProps({
  isHaveBankAccount: Boolean
});

const { user } = useAuth();

const form = useForm<{
  amount: number
}>({
    amount: 0,
});

const amount = ref<number>(0);
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