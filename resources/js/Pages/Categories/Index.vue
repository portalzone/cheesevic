<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import DangerButton from '@/Components/DangerButton.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';
import Swal from 'sweetalert2';

const props = defineProps({
    categories: {type: Object}
});

const  form = useForm({
    id: ''
});

const deleteCategory = (id,name) => {
    const alerta = Swal.mixin({
        buttonsStyling:true
    });
    alerta.fire({
        title: 'Are you sure delete '+name+' ?',
        icon: 'question', showCancelButton:true,
        confirmButtonText:'<i class="fa-solid fa-check"></i>Yes,delete',
        cancelButtonText: '<i class="fa-solid fa-ban"></i> Cancel'
    }).then((result)=>{
        if(result.isConfirmed){
            form.delete(route('categories.destroy',id));
        }
    });
}
</script>

<template>
    <Head title="Categories" />

    <AppLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Categories</h2>
        </template>

        <div class="py-0">
            <div class="bg-slate-800 grid v-screen place-items-center">
                <div class="mt-3 mb-3 flex">
                    <Link :href="route('categories.create')"
                    :class="'px-4 py-3 bg-white text-lg text-black border rounded-md font-semibold'" >
                    <i class="fa-solid fa-plus-circle"></i>Add
                </Link>                    
                </div>
            </div>
            <div class="bg-slate-700 grid v-screen place-items-center">
                <table class="bg-white table-auto border border-gray-400 rounded-lg">
                    <thead>
                        <tr class="text-xl p-4 text-white uppercase bg-slate-900 dark:bg-gray-700 dark:text-gray-400">
                            <th class="px-4 py-4">#</th>
                            <th class="px-4 py-4">Categories</th>
                            <th class="px-4 py-4">Edit</th>
                            <th class="px-4 py-4">Delete</th>

                        </tr>
                    </thead>
                    <tbody class="text-lg">
                        <tr v-for="cat, i in categories" :key="cat.id">
                        <td class="border border-gray-400 px-4 py-4 font-bold">{{ (i+1) }}</td>
                        <td class="border border-gray-400 px-4 py-4">{{ cat.name }}</td>
                        <td class="border border-gray-400 px-4 py-4">
                            <Link :href="route('categories.edit', cat.id)"
                    :class="'px-4 py-2 bg-yellow-400 text-white border rounded-md font-semibold text-xs'" >
                    <i class="fa-solid fa-edit"></i>Edit
                </Link>  
                        </td>
                        <td class="border border-gray-400 px-4 py-4">
                            <DangerButton @click="$event => deleteCategory(cat.id,cat.name)">
                                <i class="fa-solid fa-trash"></i> Delete
                            </DangerButton>
                        </td>
                    </tr>
                    </tbody>

                </table>
            </div>
        </div>
    </AppLayout>
</template>
