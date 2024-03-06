<script setup>

import AppLayout from '@/Layouts/AppLayout.vue';
import DangerButton from '@/Components/DangerButton.vue';
import RestoreButton from '@/Components/RestoreButton.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import TextArea from '@/Components/TextArea.vue';
import SelectInput from '@/Components/SelectInput.vue';
import WarningButton from '@/Components/WarningButton.vue';
import SecondaryButton from '@/Components/SecondaryButton.vue';
import Modal from '@/Components/Modal.vue';
import { usePage } from '@inertiajs/inertia-vue3';
import { Head, useForm } from '@inertiajs/vue3';
import { nextTick, ref} from 'vue';
import Swal from 'sweetalert2';
import VueTailWindPagination from '@ocrv/vue-tailwind-pagination';

const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
const nameInput = ref(null);
const modal = ref(false);
const title = ref('');
const operation = ref(1);
const id = ref('');

const props = defineProps({
    posts: { type: Object },
    categories: { type: Object },
});



const form = useForm({
    _method: null,
    name: '',
    body: '',
    category_id: 0,
    image: null, // Change to null to represent no image initially
});

const formPage = useForm({});

const onPageClick = (event) => {
    formPage.get(route('posts.delete', { page: event }));
}

const openModal = (op, name, body, category, post, image) => {
    modal.value = true;
    nextTick(() => nameInput.value.focus());

    operation.value = op;
    id.value = post;
    if (op == 1) {
        title.value = 'Create post';
    } else {
        title.value = 'Edit post';
        form.name = name;
        form.body = body;
        form.image = image;
        form.category_id = category;
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
    formData.append('body', form.body);
    formData.append('category_id', form.category_id);
    if (form.image) {
        formData.append('image', form.image);
    }

    if (operation.value == 1) {
        form.post(route('posts.store'), {
            preserveScroll: true,
            onSuccess: () => { ok('Post created'); },
            onError: (errors) => { console.error('Error updating post:', errors); },
        });
    } else {
        form.post(route('posts.update', id.value), {
            preserveState: true,
            onSuccess: () => { ok('Post updated'); },
            onError: (errors) => { console.error('Error updating post:', errors); },
        });
    }
}


const ok = (message) => {
    form.reset();
    closeModal();
    Swal.fire({ title: message, icon: 'success' });
}

const deletePost = (id, name) => {
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
            form.delete(route('posts.destroy', id), {
                onSuccess: () => { ok('Post deleted'); }
            });
        }
    });
}
const restorePost = (id, name) => {
    const alerta = Swal.mixin({
        buttonsStyling: true
    });
    alerta.fire({
        title: `Are you sure you want to restore ${name}?`,
        icon: 'question',
        showCancelButton: true,
        confirmButtonText: '<i class="fa-solid fa-check"></i> Yes, restore',
        cancelButtonText: '<i class="fa-solid fa-ban"></i> Cancel'
    }).then((result) => {
        if (result.isConfirmed) {
            form.put(route('posts.restore', id), {
            preserveState: true,
            onSuccess: () => { ok('Post Restored'); },
            onError: (errors) => { console.error('Error restoring post:', errors); },
        });

        }
    });
}
// Define a function to truncate text to a certain number of words
const truncateText = (text, limit = 20) => {
  const words = text.split(' ');
  if (words.length > limit) {
    return words.slice(0, limit).join(' ') + '...'; // Append ellipsis if text is truncated
  }
  return text;
}
</script>


<template>
    <Head title="Deleted Posts" />

    <AppLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Posts</h2>
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
                                            Title
                                        </th>
                                        <th scope="col" class="px-6 py-3">
                                            Author
                                        </th>
                                        <th scope="col" class="px-6 py-3">
                                            Image
                                        </th>
                                        <th scope="col" class="px-6 py-3">
                                            Body
                                        </th>
                                        <th scope="col" class="px-6 py-3">
                                            Category
                                        </th>
                                        <th scope="col" class="px-6 py-3">
                                            Edit
                                        </th>
                                        <th scope="col" class="px-6 py-3">
                                            Restore
                                        </th>
                                        <th scope="col" class="px-6 py-3">
                                            Delete
                                        </th>                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="po, i in posts.data" :key="po.id" class="text-base bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                        <td class="px-2 py-2 text-gray-900 dark:text-white">{{ (i+1) }}</td>
                        <td class="px-2 py-2 text-gray-900 dark:text-white">{{ po.name }}</td>
                        <td class="px-2 py-2 text-gray-900 dark:text-white">Published by: {{ po.user.name }}</td>
                        <td class="w-16 h-16"><img :src="'/storage/' + po.image" alt="Post Image" v-if="po.image"></td>
                        <td class="px-2 py-2 text-gray-900 dark:text-white">{{ truncateText(po.body) }}</td>
                        <td class="px-2 py-2 text-gray-900 dark:text-white">{{ po.category }}</td>
                        <td class="px-2 py-2">
                            <WarningButton 
                            @click="$event => openModal(2, po.name, po.body, po.category_id, po.id, po.image)">
                                <i class="fa-solid fa-edit"></i> Edit
                            </WarningButton>
                        </td>
                        <td class="px-2 py-2">
                            <RestoreButton @click="$event => restorePost(po.id,po.name)">
                                <i class="fa-solid fa-search"></i>Restore
                            </RestoreButton>
                        </td>
                        <td class="px-2 py-2">
                            <DangerButton @click="$event => deletePost(po.id,po.name)">
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
                    :current="posts.currentPage" :total="posts.total"
                    :per-page="posts.perPage"
                    @page-changed="$event=> onPageClick($event)">
                    
                </VueTailWindPagination>
            </div>
        </div>
        <Modal :show="modal" @close="closeModal">
            <h2 class="p-3 text-lg font.medium text-gray-900">{{ title }}</h2>
            
      

            <div class="p-3 ">
                <InputLabel for="name" value="Title:"></InputLabel>
                <TextInput id="name" ref="nameInput"
                v-model="form.name"
                type="text" class="mt-1 block w-3/4" 
                placeholder="Title"></TextInput>
                <InputError :message="form.errors.name" class="mt-2"></InputError>
            </div>
            <div v-if="form.image" class="p-3 w-16 h-16"> 
                <img :src="'/storage/' + form.image" alt="Post Image" v-if="form.image">

            </div>
            <div class="p-3">
                <InputLabel for="image" value="Upload Image:"></InputLabel>
                <input id="image" type="file" name="image" @change="uploadImage"  class="mt-1 block w-3/4"/>
                <InputError :message="form.errors.image" class="mt-2"></InputError>
            </div>

            <div class="p-3">
                <InputLabel for="category_id" value="Category:"></InputLabel>
                <SelectInput id="category_id" :options="categories"
                  v-model="form.category_id"
                  :modelValue ="form.category_id"
                class="mt-1 block w-3/4"></SelectInput>
                <InputError :message="form.errors.category_id" class="mt-2"></InputError>
            </div>
            <div class="p-3">
                <InputLabel for="body" value="Post Content:"></InputLabel>
                <TextArea id="body" 
                v-model="form.body"
                type="text" class="mt-1 block w-3/4" placeholder="Introduction 
                Body 
                Conclusion"></TextArea>
                <InputError :message="form.errors.body" class="mt-2"></InputError>
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
