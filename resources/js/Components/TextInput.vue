<script setup>
import { onMounted, ref } from "vue";
import { vMaska } from "maska";

defineProps({
    modelValue: {
        type: String,
        required: true,
    },
    mask: {
        type: String,
        default: null,
        required: false,
    },
});

defineEmits(["update:modelValue"]);

const input = ref(null);

onMounted(() => {
    if (input.value.hasAttribute("autofocus")) {
        input.value.focus();
    }
});

defineExpose({ focus: () => input.value.focus() });
</script>

<template>
    <!-- <input
        class="border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm"
        :value="modelValue"
        @input="$emit('update:modelValue', $event.target.value)"
        ref="input"

        v-maska
        :data-maska="mask"
    /> -->
    <input
        class="rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 dark:focus:border-indigo-600 dark:focus:ring-indigo-600"
        :value="modelValue"
        @input="$emit('update:modelValue', $event.target.value)"
        ref="input"
        v-maska
        :data-maska="mask"
    />
</template>
<style>
@media (prefers-color-scheme: dark) {
    input {
        color-scheme: dark;
    }
}
</style>
