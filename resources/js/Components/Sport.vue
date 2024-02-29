<script setup>
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
  <div class="py-4">
    <div class="mx-auto max-w-7xl sm:px-3 lg:px-2">
        <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
            <div class=" bg-white border-b border-gray-200">
              <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
                  <div class="w-full text-lg text-left text-black dark:text-gray-400">
              <h1 class="text-2xl p-4 text-white uppercase bg-slate-900 dark:bg-gray-700 dark:text-gray-400">
                Sport
              </h1>
                <div v-if="posts.length === 0">Loading...</div>
                  <div v-else>
                    <div v-for="post in posts" :key="post.id">
                      <div class="pt-2 grid grid-cols-1 md:grid-cols-9 gap-6 lg:gap-8">
                        <div class="col-span-1 w-16 h-16"><img :src="'/storage/' + post.image" alt="Post Image" v-if="post.image"></div>
                        <div class="col-span-8 ">
                          <h2  class="text-lg font-medium px-5">{{ post.name }}</h2>
                          <p class="px-5">{{ truncateText(post.body) }}</p>
                        </div>                      
                      <hr>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
              </div>
            </div>
          </div>
</template>

<script>
import axios from 'axios';

export default {
  data() {
    return {
      posts: []
    };
  },
  mounted() {
    axios.get('/sport-posts')
      .then(response => {
        this.posts = response.data;
      })
      .catch(error => {
        console.error('Error fetching sport posts: ', error);
      });
  }
}
</script>
