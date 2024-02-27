<script setup>
import Latest from '@/Components/Latest.vue';
import Sport from '@/Components/Sport.vue';
import Politics from '@/Components/Politics.vue';
import Education from '@/Components/Education.vue';
import Religion from '@/Components/Religion.vue';
import Finance from '@/Components/Finance.vue';
import Entertainment from './Entertainment.vue';
</script>

<template>
    <div class="">
        <div class="p-2 lg:p-2 bg-white border-b border-gray-200 sm:rounded-lg">
            <Latest/>
            
        </div>
        <div class="p-2 lg:p-2 bg-white border-b border-gray-200 sm:rounded-lg">            
            <Sport/>
        </div>
        <div class="p-2 lg:p-2 bg-white border-b border-gray-200 sm:rounded-lg">            
            <Politics/>
        </div>
        <div class="p-2 lg:p-2 bg-white border-b border-gray-200 sm:rounded-lg">            
            <Education/>
        </div>
        <div class="p-2 lg:p-2 bg-white border-b border-gray-200 sm:rounded-lg">            
            <Religion/>
        </div>
        <div class="p-2 lg:p-2 bg-white border-b border-gray-200 sm:rounded-lg">            
            <Finance/>
        </div>
        <div class="p-2 lg:p-2 bg-white border-b border-gray-200 sm:rounded-lg">            
            <Entertainment/>
        </div>

        
    </div>
</template>