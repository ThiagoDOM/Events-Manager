<template>
    <Modal :show="true" @close="closeModal">
        <div class="p-6">
            <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                <font-awesome-icon icon="triangle-exclamation" class="text-red-600" /> Excluir
            </h2>

            <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                Tem certeza de que deseja excluir este item? Essa ação não pode ser desfeita.
            </p>

            <div class="mt-6 flex justify-end">
                <SecondaryButton @click="closeModal"> Cancelar </SecondaryButton>
                <DangerButton class="ms-3" :class="{ 'opacity-25': loading }" :disabled="loading"
                    :html="{ '...': loading }" @click="deleteUser(id, url)">
                    Excluir Item
                </DangerButton> <Loading class="ml-3 mt-1" v-if="loading"/>
            </div>
        </div>
    </Modal>
</template>
<script setup>
import { defineEmits, ref } from 'vue';
import Modal from '@/Components/Modal.vue';
import DangerButton from '@/Components/DangerButton.vue';
import SecondaryButton from '@/Components/SecondaryButton.vue';
import axios from 'axios';
import { useToast } from 'vue-toast-notification';
import 'vue-toast-notification/dist/theme-sugar.css';
import Loading from '@/Components/Loading.vue';
// import 'vue-toast-notification/dist/theme-default.css';

const props = defineProps({
    id: {
        type: Number
    },
    additionalParameter: {
        type: Number,
        required: false
    },
    url: {
        type: String
    },
});

const emit = defineEmits(['close', 'error', 'success']);
const $toast = useToast();
const options = {
    position: 'top-right',
    duration: 5000
};
const loading = ref(false);

const deleteUser = (id, url) => {
    loading.value = true;
    if(props.additionalParameter){
        axios.delete(route(url, [props.additionalParameter, id]))
        .then(() => {
            successModal();
        })
        .catch((err) => {
            errorModal(err?.response.status);
        })
        .finally(() => {
            loading.value = false;
        });
    } else {
        axios.delete(route(url, id))
        .then(() => {
            successModal();
        })
        .catch((err) => {
            errorModal(err?.response.status);
        })
        .finally(() => {
            loading.value = false;
        });
    }
};
const closeModal = () => {
    emit('close');
}
const successModal = () => {
    $toast.success("Item excluído com sucesso!", options);
    emit('success');
    closeModal();
}

const errorModal = (status) => {
    if(status == 404)
        $toast.error("Item não encontrado!", options);
    else if(status == 401)
        $toast.error("No permission to delete!", options);
    else
        $toast.error("Ops! Ocorreu um erro!", options);

    console.log('erro!');
    emit('error');
}

</script>
