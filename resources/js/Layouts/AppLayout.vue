<script setup>
import { ref } from 'vue';
import { Head, Link, router } from '@inertiajs/vue3';
import ApplicationMark from '@/Components/ApplicationMark.vue';
import Banner from '@/Components/Banner.vue';
import Dropdown from '@/Components/Dropdown.vue';
import DropdownLink from '@/Components/DropdownLink.vue';
import NavLink from '@/Components/NavLink.vue';
import ResponsiveNavLink from '@/Components/ResponsiveNavLink.vue';
import '@fortawesome/fontawesome-free/css/all.css';


defineProps({
    title: String,
});

const isNavOpen = ref(false);

// Function to toggle the navigation
const toggleNav = () => {
  isNavOpen.value = !isNavOpen.value;
};


const showingNavigationDropdown = ref(false);

const switchToTeam = (team) => {
    router.put(route('current-team.update'), {
        team_id: team.id,
    }, {
        preserveState: false,
    });
};

const logout = () => {
    router.post(route('logout'));
};
</script>

<template>
    <div>
        <Head :title="title" />

        <Banner />

        <div class="min-h-screen bg-slate-700">
            <div class="hidden md:block fixed top-0 left-0 h-screen bg-slate-900 border-r border-gray-100 flex-col justify-between z-50">
    <div class="pt-12">
        <div class="pt-12 px-4 gap-6 lg:gap-8">
            <div class="md:flex md:flex-col items-center">
                <NavLink :href="route('donation')" :active="route().current('donation')" class="text-white mb-2 p-4" title="Donations"><i class="fa-solid fa-donate"></i> </NavLink>
                <NavLink :href="route('scholarship')" :active="route().current('scholarship')" class="text-white mb-2 p-4" title="Scholarship"><i class="fa-solid fa-graduation-cap"></i> </NavLink>
                <NavLink :href="route('suggestion')" :active="route().current('suggestion')" class="text-white mb-2 p-4" title="Suggestions"><i class="fa-solid fa-pen-to-square"></i> </NavLink>
                <NavLink :href="route('publish')" :active="route().current('publish')" class="text-white mb-2 p-4"  title="Publish"><i class="fa-solid fa-upload"></i> </NavLink>
            </div>
        </div>
    </div>
</div>



            <nav class="fixed top-0 left-0 w-full z-50 bg-slate-900 border-b border-gray-100">
                          <!-- Toggle button for the left nav -->
                          <button @click="toggleNav()" class="fixed top-5 left-5 z-50 p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 focus:text-gray-500 transition duration-150 ease-in-out">
    <svg
        class="h-6 w-6"
        stroke="currentColor"
        fill="none"
        viewBox="0 0 24 24"
    >
        <!-- Lines to form an 'X' icon -->
        <path
            :class="{'hidden': ! isNavOpen, 'inline-flex':  isNavOpen }"
            stroke-linecap="round"
            stroke-linejoin="round"
            stroke-width="2"
            d="M6 18L18 6M6 6l12 12"
        />
        <!-- Lines to form a hamburger icon when nav is open -->
        <path
            :class="{'hidden': isNavOpen, 'inline-flex': ! isNavOpen }"
            stroke-linecap="round"
            stroke-linejoin="round"
            stroke-width="2"
            d="M4 6h16M4 12h16M4 18h16"
        />
    </svg>
</button>

<!-- Navigation Menu -->
<nav :class="{ 'translate-x-0': isNavOpen, '-translate-x-full': !isNavOpen }" class="fixed top-0 left-0 h-full w-60 bg-gray-900 text-white pt-16 transition-transform ease-in-out duration-300 z-40">
    <!-- Your navigation links here -->
    <ul>
        <li><a href="#" class="block px-4 py-2 hover:bg-gray-800">Donation</a></li>
        <li><a href="#" class="block px-4 py-2 hover:bg-gray-800">Scholarship</a></li>
        <li><a href="#" class="block px-4 py-2 hover:bg-gray-800">Suggestion</a></li>
        <li><a href="#" class="block px-4 py-2 hover:bg-gray-800">Publish</a></li>
        <li><a href="#" class="block px-4 py-2 hover:bg-gray-800">About Us</a></li>
        <li><a href="#" class="block px-4 py-2 hover:bg-gray-800">Contact Us</a></li>
    </ul>
</nav>
                <!-- Primary Navigation Menu -->
                <div class="max-w-7xl mx-auto px-4 md:px-6 lg:px-8">
                    <div class="flex justify-between h-16">
                        <div class="flex ml-12">
                            <!-- Logo -->
                            <div class="shrink-0 flex items-center">
                                <Link :href="route('dashboard')">
                                    <ApplicationMark class="block h-9 w-auto" />
                                </Link>
                            </div>

                            <!-- Navigation Links -->
                            <div class="hidden space-x-8 md:-my-px md:ms-10 md:flex">
                                <NavLink :href="route('dashboard')" :active="route().current('dashboard')">
                                    Dashboard
                                </NavLink>
                            </div>
                            <div class="hidden space-x-8 md:-my-px md:ms-10 md:flex"  v-if="$page.props.auth.user.power === 9">
                                <NavLink :href="route('categories.index')" :active="route().current('categories.index')">
                                    Categories
                                </NavLink>
                            </div>
                            <div class="hidden space-x-8 md:-my-px md:ms-10 md:flex"  v-if="($page.props.auth.user.power === 9 || $page.props.auth.user.power === 3)">
                                <NavLink :href="route('posts.index')" :active="route().current('posts.index')">
                                    Posts
                                </NavLink>
                            </div>
                            <div class="hidden space-x-8 md:-my-px md:ms-10 md:flex"  v-if="$page.props.auth.user.power === 9">
                                <NavLink :href="route('post.delete')" :active="route().current('post.delete')">
                                    Deleted Post
                                </NavLink>
                            </div>
                            <div class="hidden space-x-8 md:-my-px md:ms-10 md:flex"  v-if="$page.props.auth.user.power === 9">
                                <NavLink :href="route('users.index')" :active="route().current('users.index')">
                                    Users
                                </NavLink>
                            </div>
                            <div class="hidden space-x-8 md:-my-px md:ms-10 md:flex">
                                <NavLink :href="route('about')" :active="route().current('about')">
                                    About Us
                                </NavLink>
                            </div>
                            <div class="hidden space-x-8 md:-my-px md:ms-10 md:flex">
                                <NavLink :href="route('contact')" :active="route().current('contact')">
                                    Contact Us
                                </NavLink>
                            </div>
                        </div>

                        <div class="hidden md:flex md:items-center md:ms-6">
                            <div class="ms-3 relative">
                                <!-- Teams Dropdown -->
                                <Dropdown v-if="$page.props.jetstream.hasTeamFeatures" align="right" width="60">
                                    <template #trigger>
                                        <span class="inline-flex rounded-md">
                                            <button type="button" class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-white bg-slate-700 hover:text-gray-300 focus:outline-none focus:bg-gray-50 active:bg-gray-50 transition ease-in-out duration-150">
                                                {{ $page.props.auth.user.current_team.name }}

                                                <svg class="ms-2 -me-0.5 h-4 w-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 15L12 18.75 15.75 15m-7.5-6L12 5.25 15.75 9" />
                                                </svg>
                                            </button>
                                        </span>
                                    </template>

                                    <template #content>
                                        <div class="w-60">
                                            <!-- Team Management -->
                                            <div class="block px-4 py-2 text-xs text-white">
                                                Manage Team
                                            </div>

                                            <!-- Team Settings -->
                                            <DropdownLink :href="route('teams.show', $page.props.auth.user.current_team)">
                                                Team Settings
                                            </DropdownLink>

                                            <DropdownLink v-if="$page.props.jetstream.canCreateTeams" :href="route('teams.create')">
                                                Create New Team
                                            </DropdownLink>

                                            <!-- Team Switcher -->
                                            <template v-if="$page.props.auth.user.all_teams.length > 1">
                                                <div class="border-t border-gray-200" />

                                                <div class="block px-4 py-2 text-xs text-white">
                                                    Switch Teams
                                                </div>

                                                <template v-for="team in $page.props.auth.user.all_teams" :key="team.id">
                                                    <form @submit.prevent="switchToTeam(team)">
                                                        <DropdownLink as="button">
                                                            <div class="flex items-center">
                                                                <svg v-if="team.id == $page.props.auth.user.current_team_id" class="me-2 h-5 w-5 text-green-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                                </svg>

                                                                <div>{{ team.name }}</div>
                                                            </div>
                                                        </DropdownLink>
                                                    </form>
                                                </template>
                                            </template>
                                        </div>
                                    </template>
                                </Dropdown>
                            </div>

                            <!-- Settings Dropdown -->
                            <div class="ms-3 relative">
                                <Dropdown align="right" width="48">
                                    <template #trigger>
                                        <button v-if="$page.props.jetstream.managesProfilePhotos" class="flex text-sm border-2 border-transparent rounded-full focus:outline-none focus:border-gray-300 transition">
                                            <img class="h-8 w-8 rounded-full object-cover" :src="$page.props.auth.user.profile_photo_url" :alt="$page.props.auth.user.name">
                                        </button>

                                        <span v-else class="inline-flex rounded-md">
                                            <button type="button" class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-white bg-slate-700 hover:text-gray-400 focus:outline-none focus:bg-gray-200 active:bg-gray-50 transition ease-in-out duration-150">
                                                {{ $page.props.auth.user.name }}

                                                <svg class="ms-2 -me-0.5 h-4 w-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5" />
                                                </svg>
                                            </button>
                                        </span>
                                    </template>

                                    <template #content>
                                        <!-- Account Management -->
                                        <div class="block px-4 py-2 text-xs text-black">
                                            Manage Account
                                        </div>

                                        <DropdownLink :href="route('profile.show')">
                                            Profile
                                        </DropdownLink>

                                        <DropdownLink v-if="$page.props.jetstream.hasApiFeatures" :href="route('api-tokens.index')">
                                            API Tokens
                                        </DropdownLink>

                                        <div class="border-t border-gray-200" />

                                        <!-- Authentication -->
                                        <form @submit.prevent="logout">
                                            <DropdownLink as="button">
                                                Log Out
                                            </DropdownLink>
                                        </form>
                                    </template>
                                </Dropdown>
                            </div>
                        </div>

                        <!-- Hamburger -->
                        <div class="-me-2 flex items-center md:hidden">
                            <button class="inline-flex items-center justify-center p-2 rounded-md text-white hover:text-gray-400 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 focus:text-white transition duration-150 ease-in-out" @click="showingNavigationDropdown = ! showingNavigationDropdown">
                                <svg
                                    class="h-6 w-6"
                                    stroke="currentColor"
                                    fill="none"
                                    viewBox="0 0 24 24"
                                >
                                    <path
                                        :class="{'hidden': showingNavigationDropdown, 'inline-flex': ! showingNavigationDropdown }"
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        stroke-width="2"
                                        d="M4 6h16M4 12h16M4 18h16"
                                    />
                                    <path
                                        :class="{'hidden': ! showingNavigationDropdown, 'inline-flex': showingNavigationDropdown }"
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        stroke-width="2"
                                        d="M6 18L18 6M6 6l12 12"
                                    />
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Responsive Navigation Menu -->
                <div :class="{'block': showingNavigationDropdown, 'hidden': ! showingNavigationDropdown}" class="md:hidden">
                    <div class="pt-2 pb-3 space-y-1">
                        <ResponsiveNavLink :href="route('dashboard')" :active="route().current('dashboard')">
                            Dashboard
                        </ResponsiveNavLink>
                    </div>
                    <div class="pt-2 pb-3 space-y-1"  v-if="$page.props.auth.user.power === 9">
                        <ResponsiveNavLink :href="route('categories.index')" :active="route().current('categories.index')">
                            Categories
                        </ResponsiveNavLink>
                    </div>
                    <div class="pt-2 pb-3 space-y-1"  v-if="($page.props.auth.user.power === 9 || $page.props.auth.user.power === 3)">
                        <ResponsiveNavLink :href="route('posts.index')" :active="route().current('posts.index')">
                            Posts
                        </ResponsiveNavLink>
                    </div>
                    <div class="pt-2 pb-3 space-y-1"  v-if="$page.props.auth.user.power === 9">
                        <ResponsiveNavLink :href="route('post.delete')" :active="route().current('post.delete')">
                            Deleted Posts
                        </ResponsiveNavLink>
                    </div>
                    <div class="pt-2 pb-3 space-y-1"  v-if="$page.props.auth.user.power === 9">
                        <ResponsiveNavLink :href="route('users.index')" :active="route().current('users.index')">
                            Users
                        </ResponsiveNavLink>
                    </div>

                    <div class="pt-2 pb-3 space-y-1">
                        <ResponsiveNavLink :href="route('about')" :active="route().current('about')">
                            About Us
                        </ResponsiveNavLink>
                    </div>
                    <div class="pt-2 pb-3 space-y-1">
                        <ResponsiveNavLink :href="route('contact')" :active="route().current('contact')">
                            Contact Us
                        </ResponsiveNavLink>
                    </div>

                    <!-- Responsive Settings Options -->
                    <div class="pt-4 pb-1 border-t border-gray-200">
                        <div class="flex items-center px-4">
                            <div v-if="$page.props.jetstream.managesProfilePhotos" class="shrink-0 me-3">
                                <img class="h-10 w-10 rounded-full object-cover" :src="$page.props.auth.user.profile_photo_url" :alt="$page.props.auth.user.name">
                            </div>

                            <div>
                                <div class="font-medium text-base text-white">
                                    {{ $page.props.auth.user.name }}
                                </div>
                                <div class="font-medium text-sm text-white">
                                    {{ $page.props.auth.user.email }}
                                </div>
                            </div>
                        </div>

                        <div class="mt-3 space-y-1">
                            <ResponsiveNavLink :href="route('profile.show')" :active="route().current('profile.show')">
                                Profile
                            </ResponsiveNavLink>

                            <ResponsiveNavLink v-if="$page.props.jetstream.hasApiFeatures" :href="route('api-tokens.index')" :active="route().current('api-tokens.index')">
                                API Tokens
                            </ResponsiveNavLink>

                            <!-- Authentication -->
                            <form method="POST" @submit.prevent="logout">
                                <ResponsiveNavLink as="button">
                                    Log Out
                                </ResponsiveNavLink>
                            </form>

                            <!-- Team Management -->
                            <template v-if="$page.props.jetstream.hasTeamFeatures">
                                <div class="border-t border-gray-200" />

                                <div class="block px-4 py-2 text-xs text-white">
                                    Manage Team
                                </div>

                                <!-- Team Settings -->
                                <ResponsiveNavLink :href="route('teams.show', $page.props.auth.user.current_team)" :active="route().current('teams.show')">
                                    Team Settings
                                </ResponsiveNavLink>

                                <ResponsiveNavLink v-if="$page.props.jetstream.canCreateTeams" :href="route('teams.create')" :active="route().current('teams.create')">
                                    Create New Team
                                </ResponsiveNavLink>

                                <!-- Team Switcher -->
                                <template v-if="$page.props.auth.user.all_teams.length > 1">
                                    <div class="border-t border-gray-200" />

                                    <div class="block px-4 py-2 text-xs text-white">
                                        Switch Teams
                                    </div>

                                    <template v-for="team in $page.props.auth.user.all_teams" :key="team.id">
                                        <form @submit.prevent="switchToTeam(team)">
                                            <ResponsiveNavLink as="button">
                                                <div class="flex items-center">
                                                    <svg v-if="team.id == $page.props.auth.user.current_team_id" class="me-2 h-5 w-5 text-green-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                    </svg>
                                                    <div>{{ team.name }}</div>
                                                </div>
                                            </ResponsiveNavLink>
                                        </form>
                                    </template>
                                </template>
                            </template>
                        </div>
                    </div>
                </div>
            </nav>

            <!-- Page Heading -->
            <header v-if="$slots.header" class="bg-slate-800 shadow">
                <div class="max-w-7xl mx-auto py-6 px-4 md:px-6 lg:px-8">
                    <slot name="header" />
                </div>
            </header>

            <!-- Page Content -->
            <main>
                <slot />
            </main>
        </div>
    </div>
</template>
