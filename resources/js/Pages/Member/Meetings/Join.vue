<script setup>
import { ref } from 'vue';
import MemberLayout from '@/Layouts/MemberLayout.vue';
import { Link } from '@inertiajs/vue3';


defineOptions({
    layout:MemberLayout
})

</script>


<template>

    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="p-4 m-4">
                        <button>Join Meeting</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

</template>
