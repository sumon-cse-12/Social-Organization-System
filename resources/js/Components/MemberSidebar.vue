<script setup>
import { Link, usePage } from '@inertiajs/vue3'

// Access current URL for highlighting
const page = usePage()

// Function to check if URL is active
const isActive = (url) => page.url.includes(url)
</script>

<template>
<aside class="main-sidebar sidebar-dark-primary elevation-4">
  <div class="sidebar" style="overflow-y: auto;">
    <!-- User Panel -->
    <div class="user-panel mt-3 pb-3 mb-3 d-flex">
      <div class="image"></div>
      <div class="info">
        <a href="#" class="d-block">Alexander Pierce</a>
      </div>
    </div>

    <!-- Sidebar Menu -->
    <nav class="mt-2">
      <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">



        <!-- Member Dashboard -->
        <li class="nav-item">
          <Link
            href="/member/dashboard"
            class="nav-link"
            :class="{ 'active': isActive('dashboard') }"
          >
            <i class="nav-icon fas fa-tachometer-alt"></i>
            <p>Dashboard</p>
          </Link>
        </li>

           <!-- Member Profile -->
        <li class="nav-item">
          <Link
            href="/member/profile"
            class="nav-link"
            :class="{ 'active': isActive('profile') }"
          >
            <i class="nav-icon fas fa-user"></i>
            <p>Profile</p>
          </Link>
        </li>

      </ul>
    </nav>
  </div>
</aside>
</template>
