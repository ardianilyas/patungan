<template>
    <Head title="Overlay" />
    <div id="overlay-container">
        <transition name="fade">
            <div v-if="showNotification" id="notification" 
                 class="my-12 mx-4 bg-blue-100 p-8 text-center text-blue-900 rounded-md shadow-md shadow-blue-200">
                <div class="text-3xl font-medium">{{ currentTitle }}</div>
                <div class="text-xl mt-2">{{ currentMessage }}</div>
                <!-- <div v-if="messageQueue.length > 0" class="text-sm mt-2">
                    ({{ messageQueue.length }} more in queue)
                </div> -->
            </div>
        </transition>
    </div>
</template>

<script setup lang="ts">
import { Head } from '@inertiajs/vue3';
import { useAuth } from '@/composables/useAuth';
import { onMounted, ref } from 'vue';

// Define an interface for the notification object
interface Notification {
    title: string;
    message: string;
}

const props = defineProps({
    token: String
});

console.log(props.token);

const showNotification = ref(false);
const currentTitle = ref('');
const currentMessage = ref('');
const messageQueue = ref<Notification[]>([]);
const isProcessing = ref(false);

const { user } = useAuth();

const displayNextMessage = () => {
    if (messageQueue.value.length > 0 && !isProcessing.value) {
        isProcessing.value = true;
        const nextNotification = messageQueue.value.shift() || { title: '', message: '' };
        currentTitle.value = nextNotification.title;
        currentMessage.value = nextNotification.message;
        showNotification.value = true;
        
        setTimeout(() => {
            showNotification.value = false;
            setTimeout(() => {
                isProcessing.value = false;
                displayNextMessage();
            }, 1000);
        }, 5000);
    }
};

const queueMessage = (title: string, message: string) => {
    messageQueue.value.push({ title, message });
    displayNextMessage();
};

onMounted(() => {
    window.Echo.channel(`donation.${props.token}`).listen("DonationSent", (e: any) => {
        console.log(e);
        // Assuming e has title and message properties
        queueMessage(e.title, e.message);
    });
});
</script>

<style scoped>
.overlay-container {
    width: 100%;
    height: 100vh; /* Full height for OBS */
    background: transparent; /* Ensure background is transparent */
    display: flex;
    justify-content: center;
    align-items: center;
}
.fade-enter-active,
.fade-leave-active {
    transition: opacity 0.3s ease;
}

.fade-enter-from,
.fade-leave-to {
    opacity: 0;
}
</style>