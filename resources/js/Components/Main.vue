<script setup>
import Latest from '@/Components/Latest.vue';
import Sport from '@/Components/Sport.vue';
import Politics from '@/Components/Politics.vue';
import Education from '@/Components/Education.vue';
import Finance from '@/Components/Finance.vue';
import Entertainment from './Entertainment.vue';
</script>

<template>
    <div>
        <div class="p-2 lg:p-2 bg-white border-b border-gray-200">
            <Latest/>
        </div>
        <div class="p-2 lg:p-2 bg-white border-b border-gray-200">            
            <Sport/>
        </div>
        <div class="p-2 lg:p-2 bg-white border-b border-gray-200">            
            <Politics/>
        </div>
        <div class="p-2 lg:p-2 bg-white border-b border-gray-200">            
            <Education/>
        </div>
        <div class="p-2 lg:p-2 bg-white border-b border-gray-200">            
            <Finance/>
        </div>
        <div class="p-2 lg:p-2 bg-white border-b border-gray-200">            
            <Entertainment/>
        </div>

        
    </div>
</template>
