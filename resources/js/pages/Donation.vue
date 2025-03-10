<template>
  <Head title="Donate" />
  <MainLayout>
    <div class="bg-white shadow-md rounded-md p-6">
      <h3 class="text-2xl text-neutral-800 font-medium">Donate to {{ creator?.name }}</h3>
      <p>Your current balance : {{ formatIDR(user.balance) }} </p>
      <form @submit.prevent="donate" class="my-4 [&>div]:mb-3">
        <div>
          <Label>Amount</Label>
          <Input v-model="form.amount" type="number" />
          <InputError :message="form.errors.amount" />
        </div>
        <div>
          <Label>Message</Label>
          <Textarea v-model="form.message"></Textarea>
          <InputError :message="form.errors.message" />
        </div>
        <div>
          <Button type="submit" :disabled="form.processing">Donate</Button>
        </div>
      </form>
    </div>
  </MainLayout>
</template>

<script setup lang="ts">
import MainLayout from "@/layouts/MainLayout.vue";
import { Input } from "@/components/ui/input";
import { Label } from "@/components/ui/label";
import InputError from "@/components/InputError.vue";
import { useForm, Head } from "@inertiajs/vue3";
import { Textarea } from "@/components/ui/textarea";
import { toast } from "vue-sonner";
import { Button } from "@/components/ui/button";
import { formatIDR } from "@/utils/currency";
import { useAuth } from "@/composables/useAuth";

const props = defineProps({
  creator: Object
})

const { user } = useAuth()

const form = useForm({
  amount: 0,
  message: ''
});

function donate() {
  form.post(route('donation.donate', props.creator?.name), {
    onSuccess: () => {
      toast.success("Donation sent successfully");
      form.reset();
    },
    onError: (e) => toast.error(e.amount)
  })
}
</script>