<script setup>
import AdminLayout from '@/Layouts/AdminLayout.vue';
import { ref, reactive, watch, computed } from 'vue';
import { Link, useForm } from '@inertiajs/vue3';
import pickBy from 'lodash/pickBy'
import debounce from 'lodash/debounce'
import { truncate } from '../../../utils/helpers';
import Pagination from '@/Pages/Shared/Pagination.vue';
import { useSwal } from '../../../pligins/swal'
const Swal = useSwal()

defineOptions({ layout: AdminLayout });

const props = defineProps({
    blog_categories: Object,
    filters: Object,
});
const del = useForm({});
// Reactive search form
const form = reactive({
    search: props.filters.search || ''
})

// Submit search with debounce
const submitSearch = debounce(() => {
    const data = pickBy(form)
    window.location.href = `/admin/blog-categories/index?${new URLSearchParams(data).toString()}`
}, 2000)

watch(form, submitSearch, { deep: true })


const confirmDelete = (id) => {
  Swal.fire({
    title: 'Are you sure?',
    text: 'This action cannot be undone!',
    icon: 'warning',
    showCancelButton: true,
    confirmButtonText: 'Yes, delete it!',
    cancelButtonText: 'Cancel',
  }).then((result) => {
    if (result.isConfirmed) {
      del.delete(`/admin/blog-category/delete/${id}`, {
        onSuccess: () => Swal.fire('Deleted!', 'Category deleted.', 'success')
      })
    }
  })
}
</script>

<template>
    <div class="container-fluid mt-4">
        <div v-if="successMessage" class="alert alert-success alert-dismissible fade show" role="alert">
            {{ successMessage }}
            <button type="button" class="btn-close" @click="successMessage = ''"></button>
        </div>

        <div class="card main-card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="card-title">All Categories</h5>
                <div class="d-flex align-items-center gap-2">
                    <div class="search-box d-flex align-items-center">
                        <i class="fas fa-search me-2"></i>
                        <input v-model="form.search" type="text" class="form-control" placeholder="Search category...">
                    </div>

                    <Link href="/admin/blog-category/create" class="btn btn-primary">
                    <i class="fas fa-plus me-2"></i>Add New Category
                    </Link>
                </div>
            </div>

            <div class="table-responsive">
                <table class="table align-middle">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Image</th>
                            <th>Status</th>
                            <th>Created At</th>
                            <th class="text-end">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-if="blog_categories.data.length === 0">
                            <td colspan="5" class="text-center text-muted py-5">
                                <i class="fas fa-search fa-2x mb-2"></i>
                                <p>No categories found.</p>
                            </td>
                        </tr>
                        <tr v-for="blog_category in blog_categories.data" :key="blog_category.id">
                            <td>{{ truncate(blog_category.name, 20) }}</td>
                            <td>
                                <img v-if="blog_category.image" :src="`/storage/${blog_category.image}`"
                                    alt="Category Image" class="rounded"
                                    style="width: 45px; height: 45px; object-fit: cover;" />
                                <span v-else>-</span>
                            </td>
                            <td>
                                <span v-if="blog_category.is_active" class="badge bg-success">Active</span>
                                <span v-else class="badge bg-secondary">Inactive</span>
                            </td>
                            <td>{{ blog_category.created_at || '-' }}</td>
                            <td class="text-end">
                                <Link :href="`/admin/blog-category/edit/${blog_category.id}`" class="action-btn"
                                    title="Edit">
                                <i class="fas fa-pencil-alt"></i>
                                </Link>

                             <!-- <Link :href="`/admin/blog-category/delete/${blog_category.id}`" class="action-btn"
                                    title="Delete">
                                <i class="fas fa-trash-alt"></i>
                                </Link> -->
                                 <button @click="confirmDelete(blog_category.id)" class="action-btn" title="Delete">
    <i class="fas fa-trash-alt"></i>
  </button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <div v-if="blog_categories.data.length > 0" class="card-footer">
                <div class="row justify-content-between align-items-center">
                    <div class="col-auto">
                        <small class="text-muted">
                            Showing <b>{{ blog_categories.from }}</b> to <b>{{ blog_categories.to }}</b> of <b>{{
                                blog_categories.total }}</b> results
                        </small>
                    </div>
                    <div class="col-auto">
                        <Pagination :links="blog_categories.links" />
                    </div>
                </div>
            </div>
        </div>

    </div>
</template>

<style scoped>
.action-btn {
    background: none;
    border: none;
    cursor: pointer;
    padding: 0.25rem 0.5rem;
    border-radius: 4px;
    transition: background-color 0.2s;
}

.action-btn:hover {
    background-color: #f1f1f1;
}
</style>
