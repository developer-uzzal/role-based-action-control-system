<template>

    <Head>
        <title>Dashboard</title>
    </Head>
    <section class="container-fluid p-0">
        <div class="row d-flex m-0" style="min-height: 100vh">

            <!-- Sidebar -->
            <div class="sidebar p-3 border-right" :class="[
                showMobileSidebar ? 'mobile-sidebar' : '',
                isMenuActive ? 'd-md-block col-md-2' : 'd-md-none',
                'd-none'
            ]">
                <div class="d-md-none text-end">
                    <button class="btn btn-light mb-2" @click="showMobileSidebar = false">
                        <i class="fa-solid fa-xmark"></i>
                    </button>
                </div>

                <div class="text-center pb-4 border-bottom">
                    <p>Role Based Access Control</p>

                </div>

                <ul class="nav flex-column">
                    <li class="nav-item" v-if="$page.props.auth.permissions.includes('view-user',)">
                        <Link class="nav-link" href="/dashboard" :class="{ active: $page.url === '/dashboard' }">
                        Dashboard
                        </Link>
                    </li>

                    <li class="nav-item" v-if="$page.props.auth.permissions.includes('view-user')">
                        <Link class="nav-link" href="/users" :class="{ active: $page.url === '/users' }">
                        Users
                        </Link>
                    </li>

                    <li class="nav-item" v-if="$page.props.auth.permissions.includes('view-user')">
                        <Link class="nav-link" href="/roles" :class="{ active: $page.url === '/roles' }">
                        Roles & Permissions
                        </Link>
                    </li>
                </ul>


            </div>
            <!-- Backdrop for mobile sidebar -->
            <div v-if="showMobileSidebar" class="mobile-sidebar-backdrop" @click="showMobileSidebar = false"></div>

            <!-- Main Content -->
            <div class=" bg-light p-0" :class="[isMenuActive ? 'col-md-10' : 'col-md-12', 'col-12']">
                <!-- Top Bar -->
                <div class="bg-white d-flex justify-content-between align-items-center flex-wrap m-0 p-2">
                    <!-- Left: Toggle & Input -->
                    <div class="d-flex align-items-center flex-grow-1">
                        <button @click="toggleSidebar" class="btn btn-light me-2">
                            <i class="fa-solid fa-bars"></i>
                        </button>

                        <input type="text" class="form-control responsive-input" placeholder="Search" />
                    </div>

                    <!-- Right: Profile Dropdown -->
                    <div class="d-flex align-items-center justify-content-end ms-auto">
                        <img src="https://developers.elementor.com/docs/assets/img/elementor-placeholder-image.png"
                            alt="" class="rounded-circle user-image" />
                        <div class="mx-2">
                            <div class="dropdown">
                                <a class="dropdown-toggle nav-link" href="#" role="button" data-bs-toggle="dropdown"
                                    aria-expanded="false">
                                    {{ $page.props.auth.user.name }}
                                </a>
                                <ul class="dropdown-menu">
                                    <li><a class="dropdown-item" href="#">Profile</a></li>
                                    <li>
                                        <Link class="dropdown-item" href="/logout">Logout</Link>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Main Content -->
                <div class="p-3">
                    <slot></slot>
                </div>
            </div>

        </div>
    </section>
</template>

<script setup>
import { Link } from '@inertiajs/vue3';
import { ref } from 'vue'
import { Head } from '@inertiajs/vue3';

const isMenuActive = ref(true)
const showMobileSidebar = ref(false)

const toggleSidebar = () => {
    if (window.innerWidth <= 768) {
        showMobileSidebar.value = !showMobileSidebar.value
    } else {
        isMenuActive.value = !isMenuActive.value
    }
}

</script>

<style scoped>
.responsive-input {
    width: 300px !important;
}

@media screen and (max-width: 768px) {
    .responsive-input {
        width: 150px !important;
    }
}

.mobile-sidebar {
    display: block !important;
    position: fixed;
    top: 0;
    left: 0;
    width: 75%;
    height: 100vh;
    background-color: #ffffff;
    z-index: 1050;
    transition: transform 0.3s ease-in-out;
    overflow-y: auto;
}

@media (min-width: 768px) {
    .mobile-sidebar {
        display: none !important;
    }

}

.mobile-sidebar-backdrop {
    position: fixed;
    top: 0;
    left: 0;
    width: 100vw;
    height: 100vh;
    background-color: rgba(0, 0, 0, 0.4);
    z-index: 1040;
}

@media screen and (max-width: 768px) {
    .user-image {
        width: 30px;
        height: 30px;
    }

}

@media screen and (min-width: 768px) {
    .user-image {
        width: 50px;
        height: 50px;
    }

}

.nav-link.active {
    color: #0598ec !important;
}

.nav-link {
    color: #000;
}
</style>
