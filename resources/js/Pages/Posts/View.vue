<script setup>

import GuestLayout from '@/Layouts/GuestLayout.vue';
import Side from '@/Components/Side.vue';
import {Link} from '@inertiajs/vue3';

// const props = defineProps({
//     posts: { type: Object },
//     categories: { type: Object }  
// });


</script>
<template>
    <GuestLayout :title="$props.post.category.name + ' - ' + $props.post.name">
        <template #header>
            <h2 class="pt-12 font-semibold text-xl text-white leading-tight">
                <Link :href="route('dashboard')" :active="route().current('dashboard')">
                    Home
                </Link>
                - {{ $props.post.category.name }}
            </h2>
        </template>
        
        <div class="py-4">
      <div class="mx-auto max-w-full md:px-3 lg:px-2">
        <div class="grid grid-cols-1 md:grid-cols-8 gap-6 lg:gap-8">
            <div class="col-span-1 "></div>
                    <div class="col-span-5 ">
        <div class="overflow-hidden bg-white shadow-sm md:rounded-lg">
          <div class=" bg-white border-b border-gray-200">
            <div class="relative overflow-x-auto shadow-md md:rounded-lg">
              <div class="w-full text-lg text-left text-black dark:text-gray-400">
                <h1 class="text-2xl p-4 text-white uppercase bg-slate-900 dark:bg-gray-700 dark:text-gray-400">
                    {{ $props.post.category.name }} - {{ $props.post.name }}
                </h1>
                <!-- Display the image if it exists -->
              <img :src="'/storage/' + $props.post.image" alt="Post Image" v-if="$props.post.image" class="mx-auto mt-4 rounded-lg w-1/2">
                <div class="p-8">{{ $props.post.body }}</div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="col-span-2"><Side/></div>
      </div>
    </div>
    </div>
</GuestLayout>
</template>
  
  <script>
  export default {
    props: {
      post: {
        type: Object,
        required: true
      }
    }
  };
  </script>
  