<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import TextArea from '@/Components/TextArea.vue';
import { Link} from '@inertiajs/inertia-vue3';
import { Head, useForm } from '@inertiajs/vue3';
import { nextTick, ref, defineProps } from 'vue';
import Swal from 'sweetalert2';
const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

const props = defineProps({ posts: {type:Object}});
const id = ref('');
const form = useForm({
    name:props.posts.name,
    body:props.posts.body,
});
id.value = props.posts.id;


const save = () => {
    
    const formData = new FormData();
    formData.append('_token', csrfToken); // Add CSRF token
    formData.append('name', form.name);
    formData.append('body', form.body);
    if (form.image) {
        formData.append('image', form.image);
    }
    form.put(route('posts.update', id.value), {
            preserveState: true,
            onSuccess: () => { ok('Post updated'); },
            onError: (errors) => { console.error('Error updating post:', errors); },
        });

}



</script>

<template>
        <AppLayout :title="'Edit ' + posts.name">
        <template #header>
            <h2 class="pt-12 font-semibold text-xl text-white leading-tight">
                <Link :href="route('dashboard')" :active="route().current('dashboard')">
                    Home
                </Link>
                - Edit {{ posts.name }}
            </h2>
        </template>


        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="p-4 bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <InputLabel for="name" value="Category"></InputLabel>
                        <TextInput id="name" v-model="form.name" autofocus required type="text" class="mt-1 block w-full"></TextInput>
                        <InputError :message="form.errors.name" class="mt-2"></InputError>
                        <InputLabel for="body" value="body"></InputLabel>
                        <TextArea id="body" v-model="form.body" autofocus required type="text" class="mt-1 block w-full"></TextArea>
                        <InputError :message="form.errors.body" class="mt-2"></InputError>

                        <PrimaryButton :disabled="form.processing" @click="save">
                    <i class="fa-solid fa-save"></i>Save
                </PrimaryButton>            
                </div>
            </div>
        </div>
    </AppLayout>
</template>
