<template>
    <div class="row mt-3">
        <div v-for="book in books" :key="book.id" class="col-6 col-md-3 col-lg-3 col-xl-3 mt-3">
            <div class="card rounded-0">
                <div class="card-header text-center">
                    <a :href="`/titles/${book.title_id}`">
                        <span class="badge rounded-pill text-bg-primary">{{ book.title.name }}</span>
                    </a>
                </div>
                <div class="card-body">
                    <a
                        class="d-flex justify-content-center align-items-center flex-column"
                        :href="book.url"
                        target="_blank">
                        <img
                            :src="book.curl"
                            :alt="`Cover of ${book.name}`"
                            style="width: 14vw;"
                        >
                        <p class="mt-2 text-center">
                        {{ book.name }}
                        </p>
                    </a>
                </div>
            </div>
        </div>
    </div>
</template>
<script setup>
defineProps({ books: Array });
</script>
