<template>
  <Head title="Topup" />
  <MainLayout>
    <div class="bg-white p-6 rounded-md shadow-md">
      <h3 class="text-2xl text-neutral-800 font-medium">Topup Form</h3>
      <p class="text-neutral-600 leading-relaxed">
        Your current balance : <b>{{ formatIDR(user.balance) }}</b>
      </p>
      <form @submit.prevent="submit" class="mt-4 [&>div]:mb-3">
        <div>
          <Label>Amount</Label>
          <Input type="number" v-model="form.amount" placeholder="100000" />
          <p class="text-xs text-red-500 mt-1" v-if="form.errors.amount">{{ form.errors.amount }}</p>
        </div>
        <div class="flex gap-4">
          <Button :disabled="form.processing" type="submit">
            <LoaderCircle v-if="form.processing" class="h-4 w-4 animate-spin" />
            Topup
          </Button>
        </div>
      </form>
    </div>
  </MainLayout>
</template>

<script setup lang="ts">
import MainLayout from "@/layouts/MainLayout.vue";
import { Head, useForm } from '@inertiajs/vue3'
import { Label } from "@/components/ui/label";
import { Input } from "@/components/ui/input";
import { Button } from "@/components/ui/button";
import { LoaderCircle } from "lucide-vue-next";
import { useAuth } from "@/composables/useAuth";
import { formatIDR } from "@/utils/currency";

defineProps({
  invoice: String
})

const { user } = useAuth()

const form = useForm({
  amount: ''
});

function submit() {
  form.post(route('topup.store'), {
    preserveState: true,
    preserveScroll: true,
    onSuccess: (page) => {
      const invoiceUrl = (page.props as { invoice_url?: string }).invoice
      if (invoiceUrl) {
        window.location.href = invoiceUrl
      }
    },
    onError: (errors) => {
      console.error('Form submission failed:', errors);
    },
  })
}
</script>