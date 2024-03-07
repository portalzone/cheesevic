<script setup>

import AppLayout from '@/Layouts/AppLayout.vue';
import DangerButton from '@/Components/DangerButton.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import TextArea from '@/Components/TextArea.vue';
import SelectInputUser from '@/Components/SelectInputUser.vue';
import WarningButton from '@/Components/WarningButton.vue';
import SecondaryButton from '@/Components/SecondaryButton.vue';
import Modal from '@/Components/Modal.vue';
import { usePage } from '@inertiajs/inertia-vue3';
import { Head, useForm } from '@inertiajs/vue3';
import { nextTick, ref, defineProps } from 'vue';
import Swal from 'sweetalert2';
import VueTailWindPagination from '@ocrv/vue-tailwind-pagination';

const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
const nameInput = ref(null);
const modal = ref(false);
const title = ref('');
const operation = ref(1);
const id = ref('');

const props = defineProps({
    users: { type: Object },
    powers: { type: Object },
});




const form = useForm({
    _method: null,
    name: '',
    email: '',
    power: 0,
});

const formPage = useForm({});

// // Assuming the user object is available from the page
// const { props: { user } } = usePage();

// // Function to check if the user has power equal to 3
// const filteredPosts = ref(props.posts.data); // Initially, all posts are rendered

// const hasPower3 = () => {
//     return user && user.power === 3;
// };

// if (hasPower3()) {
//     // If user has power 3, filter the posts to show only their own posts
//     filteredPosts.value = props.posts.data.filter(post => post.user_id === user.id);
// }
const onPageClick = (event) => {
    formPage.get(route('powers.index', { page: event }));
}

const openModal = (op, name, email, powered, user) => {
    modal.value = true;
    nextTick(() => nameInput.value.focus());

    operation.value = op;
    id.value = user;
    if (op == 1) {
        title.value = 'Create User';
    } else {
        title.value = 'Edit User';
        form.name = name;
        form.email = email;
        form.power = powered;
    }
}

const uploadImage = (event) => {
    form.image = event.target.files[0]
}


const closeModal = () => {
    modal.value = false;
    form.reset();
    form.clearErrors();
}

const save = () => {
    
    if (operation.value == 1) {
    form._method= 'POST';
    } else {
    form._method= 'PUT';
    }
    const formData = new FormData();
    formData.append('_token', csrfToken); // Add CSRF token
    formData.append('name', form.name);
    formData.append('body', form.email);
    formData.append('category_id', form.power);
    if (form.image) {
        formData.append('image', form.image);
    }

    if (operation.value == 1) {
        form.post(route('users.store'), {
            preserveScroll: true,
            onSuccess: () => { ok('User created'); },
            onError: (errors) => { console.error('Error updating user:', errors); },
        });
    } else {
        form.post(route('users.update', id.value), {
            preserveState: true,
            onSuccess: () => { ok('User updated'); },
            onError: (errors) => { console.error('Error updating user:', errors); },
        });
    }
}


const ok = (message) => {
    form.reset();
    closeModal();
    Swal.fire({ title: message, icon: 'success' });
}

const deleteUser = (id, name) => {
    const alerta = Swal.mixin({
        buttonsStyling: true
    });
    alerta.fire({
        title: `Are you sure you want to delete ${name}?`,
        icon: 'question',
        showCancelButton: true,
        confirmButtonText: '<i class="fa-solid fa-check"></i> Yes, delete',
        cancelButtonText: '<i class="fa-solid fa-ban"></i> Cancel'
    }).then((result) => {
        if (result.isConfirmed) {
            form.delete(route('users.destroy', id), {
                onSuccess: () => { ok('User deleted'); }
            });
        }
    });
}
// Define a function to truncate text to a certain number of words
const truncateText = (text, limit = 30) => {
  const words = text.split(' ');
  if (words.length > limit) {
    return words.slice(0, limit).join(' ') + '...'; // Append ellipsis if text is truncated
  }
  return text;
}
</script>


<template>
    <Head title="Users" />

    <AppLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Users</h2>
        </template>

        <div class="py-12">
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
                <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                    <div class="p-6 bg-white border-b border-gray-200">
                        
            <div class="bg-white grid v-screen place-items-center">
                <div class="mt-3 mb-3 flex">
                    <primary-button @click="$event => openModal(1)">
                        <i class="fa-solid fa-plus-circle"></i>Add
                    </primary-button>
                </div>
            </div>
            <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
                            <table class="w-full text-lg text-left text-black dark:text-gray-400">
                                <thead
                                    class="text-lg text-white uppercase bg-slate-800 dark:bg-gray-700 dark:text-gray-400">
                                    <tr>
                    
                        
                                        <th scope="col" class="px-6 py-3">#</th>
                                        <th scope="col" class="px-6 py-3">
                                            Name
                                        </th>
                                        <th scope="col" class="px-6 py-3">
                                            Email
                                        </th>
                                        <th scope="col" class="px-6 py-3">
                                            Rank
                                        </th>
                                        <th scope="col" class="px-6 py-3">
                                            Edit
                                        </th>
                                        <th scope="col" class="px-6 py-3">
                                            Delete
                                        </th>                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="po, i in users" :key="po.id" class="text-base bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                        <td class="px-2 py-2 text-gray-900 dark:text-white">{{ (i+1) }}</td>
                        <td class="px-2 py-2 text-gray-900 dark:text-white">{{ po.name }}</td>
                        <td class="px-2 py-2 text-gray-900 dark:text-white">{{ po.email }}</td>
                        <td class="px-2 py-2 text-gray-900 dark:text-white">{{ po.powered }}</td>
                        <td class="px-2 py-2">
                            <WarningButton 
                            @click="$event => openModal(2, po.name, po.email, po.power, po.id)">
                                <i class="fa-solid fa-edit"></i> Edit
                            </WarningButton>
                        </td>
                        <td class="px-2 py-2">
                            <DangerButton @click="$event => deleteUser(po.id,po.name)">
                                <i class="fa-solid fa-trash"></i>Delete
                            </DangerButton>
                        </td>
                    </tr>
                    </tbody>

                </table>
            </div>
        </div>
    </div>
</div>
            <div class="bg-white grid v-screen place-items-center">
                <VueTailWindPagination 
                    :current="users.currentPage" :total="users.total"
                    :per-page="users.perPage"
                    @page-changed="$event=> onPageClick($event)">
                    
                </VueTailWindPagination>
            </div>
        </div>
        <Modal :show="modal" @close="closeModal">
            <h2 class="p-3 text-lg font.medium text-gray-900">{{ title }}</h2>
            
      

            <div class="p-3 ">
                <InputLabel for="name" value="Name:"></InputLabel>
                <TextInput id="name" ref="nameInput"
                v-model="form.name"
                type="text" class="mt-1 block w-3/4" 
                placeholder="Title"></TextInput>
                <InputError :message="form.errors.name" class="mt-2"></InputError>
            </div>
            <div class="p-3 ">
                <InputLabel for="email" value="Email:"></InputLabel>
                <TextInput id="email"
                v-model="form.email"
                type="text" class="mt-1 block w-3/4" 
                placeholder="Title"></TextInput>
                <InputError :message="form.errors.email" class="mt-2"></InputError>
            </div>
            <div class="p-3">
                <InputLabel for="power" value="Rank:"></InputLabel>
                <SelectInputUser id="power" :options="powers"
                  v-model="form.power"
                  :modelValue ="form.power"
                class="mt-1 block w-3/4"></SelectInputUser>
                <InputError :message="form.errors.power" class="mt-2"></InputError>
            </div>
            <div class="p-3 mt-6">
                <PrimaryButton :disabled="form.processing" @click="save">
                    <i class="fa-solid fa-save"></i>Save
                </PrimaryButton>
            </div>
            <div class="p-3 mt-6 flex justify-end">
                <SecondaryButton :disabled="form.processing" @click="closeModal">
                    <i class="fa-solid fa-save"></i>Cancel
                </SecondaryButton>
            </div>
        
            
        </Modal>
    </AppLayout>
</template>
