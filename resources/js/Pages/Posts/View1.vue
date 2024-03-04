<script setup>
import GuestLayout from '@/Layouts/GuestLayout.vue';
import Side from '@/Components/Side.vue';
import { Link } from '@inertiajs/vue3';

// Define props
const props = defineProps({
  auth: Object,
  post: Object
});

// Extract props
const currentUser = props.auth.user;
const post = props.post;

// Function to check if the user can edit the post
function canEditPost() {
  return currentUser && (currentUser.id === post.user_id || currentUser.power === "9");
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
        <Link :href="route('posts.edit', post.id)"
              :class="'px-4 py-2 bg-yellow-400 text-white border rounded-md font-semibold text-xs flex items-center justify-center'"
        >
            <i class="fa-solid fa-edit mr-1"></i>Edit
        </Link>
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
  </GuestLayout>
</template>
