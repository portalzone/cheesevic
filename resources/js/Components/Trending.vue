<template>
  <div class="py-4">
    <div class="mx-auto max-w-7xl sm:px-3 lg:px-2">
        <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
            <div class=" bg-white border-b border-gray-200">
              <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
                  <div class="w-full text-lg text-left text-black dark:text-gray-400">
              <h1 class="text-2xl p-4 text-white uppercase bg-slate-900 dark:bg-gray-700 dark:text-gray-400">
                Trending
              </h1>
                <div v-if="posts.length === 0">Loading...</div>
                  <div v-else>
                    <div v-for="post in posts" :key="post.id">
                      <h2  class="text-lg font-medium px-5">{{ post.name }}</h2>
                        <!-- You can add more fields here as needed -->
                      <hr>
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
    axios.get('/trending-posts')
      .then(response => {
        this.posts = response.data;
      })
      .catch(error => {
        console.error('Error fetching trending posts: ', error);
      });
  }
}
</script>
