<script setup>
import { Head, Link } from '@inertiajs/vue3';
import Main from '@/Components/Main.vue';
import Side from '@/Components/Side.vue';
import GuestLayout from '@/Layouts/GuestLayout.vue';
defineProps({
    canLogin: Boolean,
    canRegister: Boolean,
    laravelVersion: String,
    phpVersion: String,
});
</script>

<template>
    <Head title="Welcome" />
    <GuestLayout>

    <div class="relative sm:flex sm:justify-center sm:items-center min-h-screen bg-dots-darker bg-center bg-slate-700 dark:bg-dots-lighter dark:bg-gray-900 selection:bg-red-500 selection:text-white">
        <!-- <div class="min-h-screen bg-gray-100">
            <nav class="bg-white sm:fixed sm:top-0 sm:end-0 p-6 text-end z-10 w-full border-b border-gray-300 px-20">
        <div v-if="canLogin" class="">
            <Link v-if="$page.props.auth.user" :href="route('dashboard')" class="font-semibold text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white focus:outline focus:outline-2 focus:rounded-sm focus:outline-red-500">Dashboard</Link>

            <template v-else>
                <Link :href="route('login')" class="font-semibold text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white focus:outline focus:outline-2 focus:rounded-sm focus:outline-red-500">Log in</Link>

                <Link v-if="canRegister" :href="route('register')" class="ms-4 font-semibold text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white focus:outline focus:outline-2 focus:rounded-sm focus:outline-red-500">Register</Link>
            </template>
        </div>
        </nav>
        </div> -->

        <div class="max-w-100 mx-auto p-6 lg:p-8">

            <div class="mt-8">
                <!-- <div class="grid grid-cols-1 md:grid-cols-8 gap-6 lg:gap-8">
                    
                    <div class="col-span-1"></div>
                    <div class="col-span-5"><Main/></div>
                    <div class="col-span-2 mt-6"><Side/></div>
                    
                </div> -->

                <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 lg:gap-8">
                    
                    <div class="col-span-1 "></div>
                    <div class="col-span-8 "><Main/></div>
                    <div class="col-span-3 pt-6"><Side/></div>
                    
                </div>
                
            </div>


            
        </div>
        
    </div>
    <div class="bg-slate-800 w-full mt-16 p-6 md:justify-between">
    <div class="ms-4 text-center text-sm text-white dark:text-gray-400 md:text-center md:ms-0">
        CheeseVic Blog: Laravel v{{ laravelVersion }} (PHP v{{ phpVersion }})
    </div>
</div>

    </GuestLayout>
</template>
<!-- 
<style>
.bg-dots-darker {
    background-image: url("data:image/svg+xml,%3Csvg width='30' height='30' viewBox='0 0 30 30' fill='none' xmlns='http://www.w3.org/2000/svg'%3E%3Cpath d='M1.22676 0C1.91374 0 2.45351 0.539773 2.45351 1.22676C2.45351 1.91374 1.91374 2.45351 1.22676 2.45351C0.539773 2.45351 0 1.91374 0 1.22676C0 0.539773 0.539773 0 1.22676 0Z' fill='rgba(0,0,0,0.07)'/%3E%3C/svg%3E");
}
@media (prefers-color-scheme: dark) {
    .dark\:bg-dots-lighter {
        background-image: url("data:image/svg+xml,%3Csvg width='30' height='30' viewBox='0 0 30 30' fill='none' xmlns='http://www.w3.org/2000/svg'%3E%3Cpath d='M1.22676 0C1.91374 0 2.45351 0.539773 2.45351 1.22676C2.45351 1.91374 1.91374 2.45351 1.22676 2.45351C0.539773 2.45351 0 1.91374 0 1.22676C0 0.539773 0.539773 0 1.22676 0Z' fill='rgba(255,255,255,0.07)'/%3E%3C/svg%3E");
    }
}
</style> -->
