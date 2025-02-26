<template>
  <nav class="sticky top-0 px-8 sm:px-10 lg:px-12 py-6 w-full bg-white shadow-md">
    <div class="flex flex-col md:flex-row md:justify-between md:items-center">
      <div class="w-full flex justify-between items-center">
        <Link href="/" class="text-2xl sm:text-3xl font-medium text-neutral-800">Patungan</Link>
        <button class="md:hidden" @click.prevent="toggleMenu">
          <MenuIcon v-if="!isOpen" />
          <XIcon v-else />
        </button>
      </div>
      <ul class="w-full justify-end mt-3 md:mt-0 md:flex flex-col md:flex-row gap-3" :class="isOpen ? 'flex' : 'hidden' ">
        <li>
          <NavbarLink :is-active="route().current('home')" :href="route('home')">Home</NavbarLink>
        </li>
        <li>
          <NavbarLink :is-active="false" href="/about">About</NavbarLink>
        </li>
        <li v-if="isAuthenticated">
          <NavbarLink :is-active="route().current('topup.*')" :href="route('topup.index')">Topup</NavbarLink>
        </li>
        <li v-if="isAuthenticated">
          <NavbarLink :is-active="route().current('dashboard.*')" :href="route('dashboard')">Dashboard</NavbarLink>
        </li>
        <li v-if="!isAuthenticated">
          <NavbarLink :is-active="route().current('login.*')" :href="route('login')">Login</NavbarLink>
        </li>
      </ul>
    </div>
  </nav>
</template>

<script setup lang="ts">
import { Link } from '@inertiajs/vue3'
import { MenuIcon, XIcon } from "lucide-vue-next";
import {ref} from "vue";
import NavbarLink from "@/components/NavbarLink.vue";
import { useAuth } from "@/composables/useAuth";

const { user, isAuthenticated } = useAuth()

const isOpen = ref(false);

function toggleMenu() {
  isOpen.value = !isOpen.value
}
</script>