<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Head } from "@inertiajs/vue3";
import Table from "@/Components/Table.vue";
import { ref } from "vue";

const props = defineProps({
    event: {
        type: Object,
    },
});

const defaultThumb = "/img/default.png";

const countdown = ref("00d 00h 00m 00s");

const updateCountdown = () => {
    const targetDate = new Date(props.event.dt_start);
    const now = new Date();
    const difference = targetDate - now;

    if (difference <= 0) {
        countdown.value = "O evento já ocorreu!";
        return;
    }

    const days = Math.floor(difference / (1000 * 60 * 60 * 24));
    const hours = Math.floor(
        (difference % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60)
    );
    const minutes = Math.floor((difference % (1000 * 60 * 60)) / (1000 * 60));
    const seconds = Math.floor((difference % (1000 * 60)) / 1000);

    countdown.value = `${days}d ${hours}h ${minutes}m ${seconds}s`;
};

updateCountdown();
const interval = setInterval(function () {
    updateCountdown();
}, 1000);
</script>

<template>
    <Head :title="event.name" />

    <AuthenticatedLayout>
        <template #header>
            <h2
                class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight"
            >
                {{ event.name }}
            </h2>
        </template>

        <div>
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <img
                    :src="event.thumbnail || defaultThumb"
                    alt=""
                    class="w-full"
                />

                <div
                    class="bg-white dark:bg-gray-800 overflow-hidden shadow-xs sm:rounded-lg mt-6"
                >
                    <div class="p-6 text-gray-900 dark:text-gray-100">
                        {{ countdown }}
                    </div>
                </div>
                <div
                    class="bg-white dark:bg-gray-800 overflow-hidden shadow-xs sm:rounded-lg mt-6"
                >
                    <div class="p-6 text-gray-900 dark:text-gray-100">
                        <p class="text-center text-2xl font-bold">Sobre</p>
                        <p class="w-full sm:px-[15%]">
                            {{ event.description }}
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
