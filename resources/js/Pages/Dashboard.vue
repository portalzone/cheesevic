<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import Welcome from '@/Components/Welcome.vue';
import Main from '@/Components/Main.vue';
import Side from '@/Components/Side.vue';
</script>

<template>
    <AppLayout title="Dashboard">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Dashboard
            </h2>
        </template>

        <div class="py-12">
            <!-- <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg grid grid-cols-1 md:grid-cols-7 gap-6 lg:gap-8">
                    <div class="col-span-5"><Main/></div>
                    <div class="col-span-2"><Side/></div>
                </div>
            </div> -->

            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="grid grid-cols-1 md:grid-cols-7 gap-6 lg:gap-8">
                    
                    <div class="col-span-5"><Main/></div>
                    <div class="col-span-2"><Side/></div>
                    
                </div>
            </div>
        </div>
        

    </AppLayout>
</template>
