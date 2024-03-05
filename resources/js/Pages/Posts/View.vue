<script setup>
import GuestLayout from '@/Layouts/GuestLayout.vue';
import Side from '@/Components/Side.vue';
import WarningButton from '@/Components/WarningButton.vue';
import DangerButton from '@/Components/DangerButton.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import SecondaryButton from '@/Components/SecondaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import TextArea from '@/Components/TextArea.vue';
import { Link } from '@inertiajs/vue3';
import { nextTick, ref} from 'vue';
import { Head, useForm } from '@inertiajs/vue3';
import Modal from '@/Components/Modal.vue';
import Swal from 'sweetalert2';

const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
// difine modal settings 
const nameInput = ref(null);
const modal = ref(false);
const title = ref('');
const operation = ref(1);
const id = ref('');

const props = defineProps({ 
  auth: {type:Object},
  post: {type:Object}
});

// Extract props
const currentUser = props.auth.user;
const post = props.post;

const form = useForm({
    _method: null,
    image: null, // Change to null to represent no image initially
    name:props.post.name,
    body:props.post.body,
});



// Function to check if the user can edit the post
function canEditPost() {
  return currentUser && (currentUser.id === post.user_id || currentUser.power === 9);
}

const openModal = (op, name, body, post, image) => {
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
    if (form.image) {
        formData.append('image', form.image);
    }

    if (operation.value == 1) {
        form.post(route('posts.store'), {
            preserveScroll: true,
            onSuccess: () => { ok('Post created');},
            // onSuccess: () => { ok('Post created'); window.location.reload(); },
            onError: (errors) => { console.error('Error updating post:', errors); },
        });
    } else {
        form.post(route('post.update', id.value), {
            preserveState: true,
            onSuccess: () => { ok('Post updated');},
            // onSuccess: () => { ok('Post updated'); window.location.reload(); },
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



</script>

<template>
  <GuestLayout :title="`${post.category.name} - ${post.name}`">
    <template #header>
      <h2 class="pt-12 font-semibold text-xl text-white leading-tight">
        <Link :href="route('dashboard')" :active="route().current('dashboard')">
          Home
        </Link>
        - {{ post.category.name }}
      </h2>
    </template>
  
    <div class="py-4">
      <div class="mx-auto max-w-full md:px-3 lg:px-2">
        <div class="grid grid-cols-1 md:grid-cols-10 lg:grid-cols-12 gap-4 lg:gap-6">
          <div class="hidden lg:block col-span-1"></div>
          <div class="col-span-8 md:col-span-7 lg:col-span-8">
            <div class="overflow-hidden bg-white shadow-sm md:rounded-lg">
              <div class=" bg-white border-b border-gray-200">
                <div class="relative overflow-x-auto shadow-md md:rounded-lg">
                  <div class="w-full text-lg text-left text-black dark:text-gray-400">
                    <div class="">
    <template v-if="canEditPost()">
        <WarningButton 
                            @click="$event => openModal(2, post.name, post.body, post.id, post.image)">
                                <i class="fa-solid fa-edit"></i> Edit
                            </WarningButton>
    </template>
</div>

                    <h1 class="text-2xl p-4 text-white uppercase bg-slate-900 dark:bg-gray-700 dark:text-gray-400">
                      {{ post.category.name }} - {{ post.name }}
                      
                    </h1>
                    <!-- Display the image if it exists -->
                    <img :src="'/storage/' + post.image" alt="Post Image" v-if="post.image" class="mx-auto mt-4 rounded-lg w-1/2">
                    <div class="p-8">{{ post.body }}</div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="col-span-3 md:col-span-3 lg:col-span-3">
            <Side/>
          </div>
        </div>
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
  </GuestLayout>
</template>
