<template>
  <Head title="Bank Account" />
  <AppLayout>
    <template #title>Bank Account</template>
    <template #subtitle>Here you can manage your bank account, so you can start withdraw your balance</template>

    <div class="my-6 p-4 max-w-3xl w-full bg-white shadow-md rounded-md">
      <form @submit.prevent="save" class="[&>div]:mb-3">
        <div>
          <Label>Bank</Label>
          <Select v-model="form.bank">
            <SelectTrigger>
              <SelectValue placeholder="Select bank" />
              <SelectContent>
                <SelectGroup>
                  <SelectLabel>Bank</SelectLabel>
                  <SelectItem v-for="bank in banks" :key="bank.id" :value="bank.channel_code">{{ bank.channel_name }}</SelectItem>
                </SelectGroup>
              </SelectContent>
            </SelectTrigger>
          </Select>
        </div>
        <div>
          <Label>Account Name</Label>
          <Input v-model="form.name" placeholder="Ardian Ilyas Fernanda" />
        </div>
        <div>
          <Label>Account Number</Label>
          <Input v-model="form.number" placeholder="010101010" />
        </div>
        <div>
          <Button type="submit">Save</Button>
        </div>
      </form>
    </div>
  </AppLayout>
</template>

<script setup lang="ts">
import { Head, useForm } from '@inertiajs/vue3'
import AppLayout from "@/layouts/AppLayout.vue";
import { Label } from "@/components/ui/label";
import { Input } from "@/components/ui/input";
import { Button } from "@/components/ui/button";
import {
  Select,
  SelectContent,
  SelectGroup,
  SelectItem,
  SelectLabel,
  SelectTrigger,
  SelectValue
} from "@/components/ui/select";
import { ref } from "vue";
import { toast } from "vue-sonner";

const props = defineProps({
  banks: Object,
  userBank: Object,
});

const form = useForm({
  bank: '',
  name: '',
  number: ''
});

function save() {
  form.post(route('dashboard.bank-account.store'), {
    onSuccess: () => toast.success('Bank account saved')
  })
}

const isExists = ref(false);

if (props.userBank?.length > 0) {
  isExists.value = true;
  form.name = props.userBank?.account_holder_name
}

if (isExists.value === true) {
  form.bank = props.userBank?.[0]?.channel_code
  form.name = props.userBank?.[0]?.account_holder_name
  form.number = props.userBank?.[0]?.account_number
}

</script>