<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
</script>

<template>
    <Head title="Dashboard" />
    <template #header>
        <h2>
            Dashboard
        </h2>
    </template>

    <div>
        <div>
            <div>
                <div >
                    You're logged in!
                </div>
            </div>
        </div>
    </div>
</template>
