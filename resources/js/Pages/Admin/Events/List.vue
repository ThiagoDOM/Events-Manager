<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Head } from "@inertiajs/vue3";
import Table from "@/Components/Table.vue";

defineProps({
    events: {
        type: Object,
    },
    query: {
        type: Object,
    },
});

const columns = [
    {
        key: "id",
        name: "ID",
    },
    {
        key: "name",
        name: "Name",
        show: true,
    },
    {
        key: "thumbnail",
        name: "Thumbnail",
        thumbnail: true,
    },
    {
        key: "dates",
        name: "Date",
    },
    {
        key: "created_at",
        name: "Created at",
    },
];
</script>

<template>
    <Head title="Events List" />

    <AuthenticatedLayout>
        <template #header>
            <h2
                class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight"
            >
                Events List
            </h2>
        </template>

        <div class="py-6">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div
                    class="bg-white dark:bg-gray-800 overflow-hidden shadow-xs sm:rounded-lg"
                >
                    <div class="p-6 text-gray-900 dark:text-gray-100">
                        <Table
                            :items="events"
                            :columns="columns"
                            :query="query"
                            :routeBase="'admin.events'"
                            :defaultThumb="'/img/default.png'"
                        />
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
