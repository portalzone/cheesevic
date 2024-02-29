<template>
    <div class="flex">
        <!-- Static Left Side Navbar -->
        <nav class="flex flex-col justify-start bg-gray-900 text-white p-4">
            <a href="#donate" class="py-2">Donate</a>
            <a href="#research" class="py-2">Research</a>
            <a href="#scholarship" class="py-2">Scholarship</a>
        </nav>

        <!-- Your existing content -->
        <div class="flex-grow">
            <!-- Your existing navigation bar code -->
            <nav class="hidden lg:block fixed inset-y-0 left-0 w-64 bg-slate-900 text-white py-4 px-6">
                <!-- Your existing navigation links -->
            </nav>

            <!-- Page Content -->
            <main>
                <slot />
            </main>
        </div>
    </div>
</template>

<style>
/* Styles for the static left side navbar */
nav {
    /* Adjust styles according to your design requirements */
    width: 200px; /* Adjust the width as needed */
    background-color: #333; /* Background color for the sidebar */
    color: white; /* Text color */
}

/* Styles for the links in the static left side navbar */
nav a {
    display: block;
    padding: 10px;
    color: white;
    text-decoration: none;
}

nav a:hover {
    background-color: #555;
}
</style>
