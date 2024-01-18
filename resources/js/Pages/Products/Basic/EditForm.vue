<template>
    <div id="basic-info">
      <div class="card-header">
        <h5>Basic Info</h5>
      </div>
      <div class="card-body pt-0 mt-3">
        <form
          role="form text-left"
          @submit.prevent="updateProductData"
          enctype="multipart/form-data"
        >
          <div class="row mb-1">
            <div for="code" class="col-md-2 col-form-label">CODE</div>
            <div class="col-md-10">
              <input
                type="text"
                class="form-control form-control-sm"
                name="code"
                id="code"
                v-model="product.code"
              />
              <!-- <small
                v-if="validationErrors.code"
                id="msg_code"
                class="text-danger form-text text-error-msg error"
                >{{ validationErrors.code }}</small> -->
            </div>
          </div>
          <div class="row mb-1">
            <div for="name" class="col-md-2 col-form-label">NAME</div>
            <div class="col-md-10">
              <input
                type="text"
                class="form-control form-control-sm"
                name="name"
                id="name"
                v-model="product.name"
              />
              <!-- <small
                v-if="validationErrors.name"
                id="msg_name"
                class="text-danger form-text text-error-msg error"
                >{{ validationErrors.name }}</small> -->
            </div>
          </div>
          <div class="row mb-1">
            <div for="name" class="col-md-2 col-form-label">Price</div>
            <div class="col-md-10">
              <input
                type="price"
                class="form-control form-control-sm"
                name="price"
                id="price"
                v-model="product.price"
              />
              <!-- <small
                v-if="validationErrors.name"
                id="msg_name"
                class="text-danger form-text text-error-msg error"
                >{{ validationErrors.email }}</small> -->
            </div>
          </div>
          <div class="row mb-1">
            <div for="name" class="col-md-2 col-form-label">Description</div>
            <div class="col-md-10">
              <input
                type="text"
                class="form-control form-control-sm"
                name="description"
                id="description"
                v-model="product.description"/>
              <!-- <small
                v-if="validationErrors.description"
                id="msg_name"
                class="text-danger form-text text-error-msg error">{{ validationErrors.description }}</small> -->
            </div>
           </div>
          <div class="text-right">
            <button
              type="button"
              class="btn btn-sm btn-round btn-outline-danger mb-0"
              @click.prevent="deleteProduct"
            >
              <font-awesome-icon icon="fa-solid fa-trash" />
              DELETE
            </button>
            <button type="submit" class="btn btn-round custom-button btn-sm mb-0">
              <font-awesome-icon icon="fa-solid fa-floppy-disk" />
              SAVE
            </button>
          </div>
        </form>
      </div>
    </div>
  </template>

  <script>
  import { Link } from "@inertiajs/vue3";
  import Multiselect from "vue-multiselect";
  import Swal from "sweetalert2";
  import { library } from "@fortawesome/fontawesome-svg-core";
  import {
    faHouse,
    faFloppyDisk,
    faTrash,
  } from "@fortawesome/free-solid-svg-icons";

  export default {
    components: {
      Link,
      Multiselect,
      library,
    },
    props: {
      productId: {
        type: Number,
        required: true,
      },
    },
    setup() {},
    data() {
      return {
        product: {},
      };
    },
    beforeMount() {
      library.add(faHouse);
      library.add(faFloppyDisk);
      library.add(faTrash);
      this.getProduct();
    },
    watch: {},
    methods: {
      async getProduct() {
        this.$nextTick(() => {
          this.$root.loader.start();
        });
        const product = (
          await axios.get(route("product.get", this.productId))
        ).data;
        this.product = product.data;
        this.$root.loader.finish();
      },

      async updateProductData() {
        //this.resetValidationErrors();
        try {
          await axios.post(
            route("product.update", this.productId),
            this.vendor
          );
          this.$root.notify.success({
            title: "Success",
            message: "Product updated successfully",
          });
        } catch (error) {
          this.convertValidationError(error);
        }
      },

      async deleteProduct() {
        try {
          Swal.fire({
            title: "Are you sure?",
            text: "You won't be able to revert this!",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#C00202",
            confirmButtonText: "Yes, delete it!",
          }).then((result) => {
            if (result.isConfirmed) {
              axios
                .delete(route("product.delete", this.product.id))
                .then((response) => {
                  this.$inertia.visit(route("product.index"));
                });
            }
          });
        } catch (error) {
          //this.convertValidationNotification(error);
        }
      },
    },
  };
  </script>

  <style lang="scss" scoped>
  .custom-button {
    background-color: #ffffff;
    border-color: #6343e9;
    color: #6343e9 !important;
  }
  .custom-button:hover {
    background-color: #6343e9;
    color: #ffffff !important;
  }
  </style>
