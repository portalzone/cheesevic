<!-- AdminLayout.vue -->

<template>
    <div>
      <!-- You can add your layout structure here -->
      <!-- For simplicity, I'm showing a basic message -->
      <div v-if="accessDenied" class="text-red-500">Access denied</div>
      <div v-else>
        <!-- Redirect to dashboard -->
        <router-view></router-view>
      </div>
    </div>
  </template>
  
  <script>
  export default {
    data() {
      return {
        accessDenied: false,
      };
    },
    created() {
      // Check the user's 'power' column value here
      // For example, you can retrieve it from Vuex state or a global variable
      const userPower = this.$store.state.user.power; // Assuming the power value is stored in Vuex state
  
      // Check if the user's power is neither 9 nor 3
      if (userPower !== 9 || userPower !== 3) {
        this.accessDenied = true; // Set accessDenied to true to display the message
        // Redirect to the dashboard or another page if needed
        // You can use Vue Router for navigation
        this.$router.push('/dashboard'); // Redirect to the dashboard page
      }
    },
  };
  </script>
  
  <style>
  /* Add your custom styles here */
  </style>
  