<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
import Table from '@/Components/Table.vue';

defineProps({
    admins: {
        type: Object,
    },
    query: {
        type: Object
    }
});

const columns = [
    {
        key: 'id',
        name: 'ID'
    },
    {
        key: 'name',
        name: 'Name'
    },
    {
        key: 'email',
        name: 'Email'
    },
];

</script>

<template>
    <Head title="Admins List" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">Admins List</h2>
        </template>

        <div class="py-6">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xs sm:rounded-lg">
                    <div class="p-6 text-gray-900 dark:text-gray-100">
                        <Table :items="admins" :columns="columns" :query="query" :routeBase="'admin.admins'" />
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
