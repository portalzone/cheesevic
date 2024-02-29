<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import Main from '@/Components/Main.vue';
import Side from '@/Components/Side.vue';
</script>

<template>
    <AppLayout title="Dashboard">
        <template #header>
            <h2 class="pt-12 font-semibold text-xl text-white leading-tight">
                Welcome back, {{ $page.props.auth.user.name }}
            </h2>
        </template>

        <div class="py-4">
            <div class="max-w-100 mx-auto sm:px-3 lg:px-4">
                <div class="grid grid-cols-1 md:grid-cols-8 gap-6 lg:gap-8">
                    
                    <div class="col-span-1 "></div>
                    <div class="col-span-5 "><Main/></div>
                    <div class="col-span-2"><Side/></div>
                    
                </div>
            </div>
        </div>
        

    </AppLayout>
</template>
