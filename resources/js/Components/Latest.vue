<script setup>
  import { ref, onMounted } from 'vue';

  const props = defineProps({
    latest: { type: Object }
  });

  onMounted(() => {
    console.log(props.latest);
  });
</script>

<template>
  <div>
    <h2>Latest Posts</h2>
    <ul>
      <li v-for="post in latest" :key="post.id">
        {{ post.name }} - {{ post.category }}
        {{ post.body }}
      </li>
    </ul>
  </div>
</template>
