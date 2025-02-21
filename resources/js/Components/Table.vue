<script setup>
import { Head, Link, router } from "@inertiajs/vue3";
import Pagination from "@/Components/Pagination.vue";
import ModalDelete from "@/Components/ModalDelete.vue";
import { ref } from "vue";
import DangerButton from "@/Components/DangerButton.vue";
import SecondaryButton from "@/Components/SecondaryButton.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";

import TextInput from "@/Components/TextInput.vue";
import Table from "@/Components/Table.vue";
import { useForm, usePage } from "@inertiajs/vue3";

import { onMounted } from "vue";
import { initFlowbite } from "flowbite";

onMounted(() => {
    initFlowbite();
});

const props = defineProps({
    items: {
        type: Object,
    },
    columns: {
        type: Array,
    },
    query: {
        type: Object,
    },
    routeBase: {
        type: String,
    },
    additionalRoute: {
        type: Number,
        required: false,
    },
    additionalParameter: {
        type: String,
        required: false,
    },
    hideSearch: {
        type: Boolean,
        default: false,
    },
    defaultThumb: {
        type: String,
    },
});

const openDeleteModal = (item) => {
    if (props.additionalParameter) {
        itemSelected.value = item.id;
        itemSelectedAdditional.value = item[props.additionalParameter];
    } else {
        itemSelected.value = item.id;
    }
    isOpen.value = true;
};

const success = () => {
    router.reload();
};

const form = useForm({
    name: props.query.name ?? "",
    order_key: props.query.order_key ?? "name",
    order: props.query.order == "true" ?? true,
});

const changeOrder = (key) => {
    form.order = key == form.order_key ? !form.order : false;
    form.order_key = key;
    if (props.additionalRoute)
        form.get(route(props.routeBase + ".index", props.additionalRoute));
    else form.get(route(props.routeBase + ".index"));
};

const isOpen = ref(false);
const itemSelected = ref(null);
const itemSelectedAdditional = ref(null);
</script>

<template>
    <form
        class="flex"
        @submit.prevent="form.get(route(routeBase + '.index', additionalRoute))"
    >
        <TextInput
            id="current_password"
            ref="currentPasswordInput"
            v-model="form.name"
            type="text"
            class="mt-1 md:w-60 w-full"
            placeholder="Name"
            v-if="!hideSearch"
        />
        <div class="flex-row-reverse">
            <button type="submit" class="px-3 py-3" v-if="!hideSearch">
                <font-awesome-icon :icon="['fas', 'magnifying-glass']" />
            </button>
        </div>

        <div class="ml-auto mt-2">
            <Link
                v-if="route().has(routeBase + '.create')"
                :href="route(routeBase + '.create', additionalRoute)"
            >
                <PrimaryButton>Create</PrimaryButton>
            </Link>
        </div>
    </form>

    <div class="relative overflow-x-auto shadow-md sm:rounded-lg mt-3">
        <table
            class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400"
        >
            <thead
                class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400"
            >
                <tr>
                    <th
                        v-for="column in columns"
                        :key="column.key"
                        scope="col"
                        class="px-6 py-3 truncate"
                        :class="{
                            'text-gray-500 dark:text-gray-200':
                                form.order_key == column.key,
                            'cursor-pointer': !column.not_sortable,
                        }"
                        @click="
                            !column.not_sortable
                                ? changeOrder(column.key)
                                : null
                        "
                    >
                        {{ column.name }}
                        <span
                            :class="{ invisible: form.order_key != column.key }"
                        >
                            <font-awesome-icon
                                v-if="form.order"
                                :icon="['fas', 'arrow-up']"
                            />
                            <font-awesome-icon
                                v-else
                                :icon="['fas', 'arrow-down']"
                            />
                        </span>
                    </th>
                    <th scope="col" class="px-6 py-3">Action</th>
                </tr>
            </thead>
            <tbody v-if="items.data.length == 0">
                <tr>
                    <td colspan="99" class="px-6 py-4">No items found.</td>
                </tr>
            </tbody>
            <tbody v-else>
                <tr
                    v-for="item in items.data"
                    :key="item.id"
                    class="odd:bg-white odd:dark:bg-gray-900 even:bg-gray-50 even:dark:bg-gray-800 border-b dark:border-gray-700"
                >
                    <template v-for="column in columns" :key="column.key">
                        <td
                            v-if="column.thumbnail"
                            class="px-6 py-4"
                            :class="{
                                'font-medium text-gray-900 whitespace-nowrap dark:text-white':
                                    column.key == 'id',
                            }"
                        >
                            <img
                                :src="item[column.key] || defaultThumb"
                                alt=""
                                class="h-20 max-w-xs"
                            />
                        </td>
                        <td
                            v-else-if="column.show"
                            class="px-6 py-4 underline"
                            :class="{
                                'font-medium text-gray-900 whitespace-nowrap dark:text-white':
                                    column.key == 'id',
                            }"
                        >
                            <a
                                :href="route(routeBase + '.show', item['id'])"
                                target="_blank"
                                >{{ item[column.key] }}</a
                            >
                        </td>
                        <td
                            v-else
                            class="px-6 py-4"
                            :class="{
                                'font-medium text-gray-900 whitespace-nowrap dark:text-white':
                                    column.key == 'id',
                            }"
                        >
                            {{ item[column.key] }}
                        </td>
                    </template>
                    <td class="px-6 py-4 inline-flex">
                        <slot :item="item" />
                        <Link
                            v-if="
                                route().has(
                                    routeBase + '.edit',
                                    additionalRoute
                                        ? [additionalRoute, item.id]
                                        : item.id
                                )
                            "
                            :data-tooltip-target="'tooltip-edit-' + item.id"
                            :href="
                                route(
                                    routeBase + '.edit',
                                    additionalRoute
                                        ? [additionalRoute, item.id]
                                        : item.id
                                )
                            "
                            class="mr-3 sm:mr-0"
                        >
                            <SecondaryButton
                                ><font-awesome-icon :icon="['fas', 'pencil']"
                            /></SecondaryButton>
                        </Link>
                        <DangerButton
                            v-if="
                                route().has(
                                    routeBase + '.destroy',
                                    additionalRoute
                                        ? [additionalRoute, item.id]
                                        : item.id
                                )
                            "
                            class="ms-0 sm:ms-3"
                            :data-tooltip-target="'tooltip-delete-' + item.id"
                            @click="openDeleteModal(item)"
                            ><font-awesome-icon :icon="['fas', 'trash']" />
                        </DangerButton>
                        <div
                            :id="'tooltip-edit-' + item.id"
                            role="tooltip"
                            class="absolute z-10 invisible inline-block px-3 py-2 text-sm font-medium text-white transition-opacity duration-300 bg-gray-900 rounded-lg shadow-sm opacity-0 tooltip dark:bg-gray-700"
                        >
                            Edit
                            <div class="tooltip-arrow" data-popper-arrow></div>
                        </div>
                        <div
                            :id="'tooltip-delete-' + item.id"
                            role="tooltip"
                            class="absolute z-10 invisible inline-block px-3 py-2 text-sm font-medium text-white transition-opacity duration-300 bg-gray-900 rounded-lg shadow-sm opacity-0 tooltip dark:bg-gray-700"
                        >
                            Delete
                            <div class="tooltip-arrow" data-popper-arrow></div>
                        </div>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
    <Pagination :pagination="items.meta" />

    <ModalDelete
        v-if="isOpen"
        @success="success()"
        @close="isOpen = false"
        :id="itemSelected"
        :additionalParameter="itemSelectedAdditional"
        :url="routeBase + '.destroy'"
    />
</template>
