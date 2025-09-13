<script setup>
import { Link, usePage } from '@inertiajs/vue3'

const page = usePage()
// exact match only
const isActive = (url) => page.url === url
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
    <nav class="mt-2">
      <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">

        <li class="nav-item">
          <Link
            href="/admin/dashboard"
            class="nav-link"
            :class="{ 'active': isActive('/admin/dashboard') }"
          >
            <i class="nav-icon fas fa-tachometer-alt"></i>
            <p>Dashboard</p>
          </Link>
        </li>

           <li class="nav-item">
          <Link
            href="/admin/payment/settings"
            class="nav-link"
            :class="{ 'active': isActive('/admin/payment/settings') }"
          >
            <i class="nav-icon fas fa-plus"></i>
            <p>Payment Settings</p>
          </Link>
        </li>

        <li class="nav-item">
          <Link
            href="/admin/dashboard/create"
            class="nav-link"
            :class="{ 'active': isActive('/admin/dashboard/create') }"
          >
            <i class="nav-icon fas fa-plus"></i>
            <p>Create</p>
          </Link>
        </li>

        <strong class="text-white">Member Management</strong>

        <li class="nav-item mt-3">
          <Link
            href="/admin/member/index"
            class="nav-link"
            :class="{ 'active': isActive('/admin/member/index') }"
          >
            <i class="nav-icon fas fa-plus"></i>
            <p>Members</p>
          </Link>
        </li>


        <strong class="text-white mt-3">Meeting Management</strong>

        <li class="nav-item mt-3">
          <Link
            href="/admin/meetings/index"
            class="nav-link"
            :class="{ 'active': isActive('/admin/meetings/index') }"
          >
            <i class="nav-icon fas fa-plus"></i>
            <p>Meetings</p>
          </Link>
        </li>

      </ul>
    </nav>
  </div>
</aside>
</template>
