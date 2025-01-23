<template>
    <div
        class="container"
        style="min-height:100vh"
        @dragover.prevent
        @drop.prevent="dropHandler">
        <BookGrid :books="books" />
    </div>

    <div
      class="modal fade"
      id="nameModal"
      tabindex="-1"
      aria-labelledby="nameModalLabel"
      aria-hidden="true"
      ref="nameModalRef"
    >
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="nameModalLabel">New Book</h5>
            <button
              type="button"
              class="btn-close"
              data-bs-dismiss="modal"
              aria-label="Close"
            ></button>
          </div>
          <form @submit.prevent="handleUpload">
              <div class="modal-body">
                  <div v-for="(file, index) in filesToUpload" :key="file.model">
                        <div class="mb-3">
                            <label for="name" class="col-form-label">Name: </label>
                            <input
                                type="text"
                                class="form-control"
                                v-model="file.name"
                                placeholder="Insert the book name"
                                name="file[]"
                                required
                            />
                        </div>
                        <div class="mb-3" v-if="!file.isNewTitle">
                            <label for="title" class="col-form-label">Title:</label>
                            <select class="form-select mb-3" id="title" v-model="file.title" required>
                                <option
                                    v-for="title in titles"
                                    :key="title.id"
                                    :value="title.id"
                                >{{ title.name}}</option>
                            </select>
                        </div>

                        <div class="mb-3" v-if="file.isNewTitle">
                            <label for="title" class="col-form-label"> Title: </label>
                            <input
                                type="text"
                                class="form-control"
                                v-model="file.title"
                                placeholder="Insert book title"
                                required
                            />
                        </div>
                        <div class="mb-3 form-check">
                            <input
                                type="checkbox"
                                class="form-check-input"
                                    :id="`title-check${file.name}`"
                                v-model="file.isNewTitle">
                            <label class="form-check-label" :for="`title-check${file.name}`">New title</label>
                        </div>
                  </div>

                  <div class="mb-3">
                        <label for="title" class="col-form-label"> Upload Password: </label>
                        <input
                          type="password"
                          class="form-control"
                          v-model="uploadPassword"
                          placeholder="Upload Password"
                        />
                  </div>
              </div>
              <div class="modal-footer">
                <button
                  type="button"
                  class="btn btn-secondary"
                  data-bs-dismiss="modal"
                >
                  Cancelar
                </button>
                <button type="submit" class="btn btn-primary">
                  Upload
                </button>
              </div>
          </form>
        </div>
      </div>
    </div>
    <div
      class="modal fade"
      id="loaderModal"
      tabindex="-1"
      aria-labelledby="loaderModalLabel"
      aria-hidden="true"
      ref="loaderModalRef"
      data-bs-backdrop="static"
      data-bs-keyboard="false"
    >
      <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content text-center">
          <div class="modal-body">
            <div class="spinner-border text-primary" role="status">
              <span class="visually-hidden">Carregando...</span>
            </div>
            <p class="mt-3">Enviando arquivo...</p>
          </div>
        </div>
      </div>
    </div>

    </template>
    <script setup>
        import { ref, onMounted, onBeforeUnmount, reactive } from "vue";
        import { Modal } from "bootstrap";
        import axios from "axios";
        import BookGrid from '@/Components/BookGrid.vue';

        const props = defineProps({ titles: Array, books: Array });

        const nameModalRef = ref(null);
        const loaderModalRef = ref(null);
        const bookName = ref("");
        const books = ref(props.books);
        const bookTitle = ref("");
        const uploadPassword = ref("");
        const bookTitleCheck = ref(false);
        let filesToUpload = reactive([]);

        let nameModalInstance = null;
        let loaderModalInstance = null;

        onMounted(() => {
            nameModalInstance = new Modal(nameModalRef.value)
            loaderModalInstance = new Modal(loaderModalRef.value)
        });

        onBeforeUnmount(() => {
            if (nameModalInstance) {
                nameModalInstance.dispose();
            }

            if (loaderModalInstance) {
                loaderModalInstance.dispose();
            }
        });

        const getTitles = () => {
            axios.get("/api/titles")
                .then((response) => console.log(response))
                .catch(error => console.log(error));
        }

        const showLoader = () => loaderModalInstance.show();

        const hideLoader = () => loaderModalInstance.toggle();

        const dropHandler = (event) => {
            const items = event.dataTransfer.items;
            openModal(items);
        }

        const openModal = (items) => {
            [...items].forEach((item, index) => {
              if (item.kind === "file") {
                const file = item.getAsFile();
                filesToUpload.push({ file: file, name: file.name, title: "", isNewTitle: false });
              }
            });

            if (filesToUpload.length > 0) {
                nameModalInstance.show();
            }

        }

        const hideModal = () => {
            nameModalInstance.hide();
        }

        const handleUpload = () => {
            hideModal();
            showLoader();

            const uploadPromises = filesToUpload.map((file) => {
                const data = new FormData();

                data.append("file", file.file);
                data.append("name", file.name);
                data.append("title", file.title);
                data.append("password", uploadPassword.value);

                return axios.post("/api/books/upload", data)
                    .then(({data}) => {
                        books.value.push(data.data.book);
                        getTitles();
                    })
                    .catch((response) => {
                        // alert(`Erro ao enviar ${file.name}: ${response.data.message}`)
                        console.log(`Erro ao enviar ${file.name}: ${response}`)
                        hideLoader();

                    })
            });

            Promise.all(uploadPromises)
                .then(() => filesToUpload.length = 0)
                .catch((error) => hideLoader())
                .finally(() => hideLoader());

        }
    </script>
