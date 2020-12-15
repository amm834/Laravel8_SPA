<template>
  <div class="container my-5">
    <div class="row">
      <div class="col-md-8 offset-md-4 d-flex justify-content-between">
        <div class="col-4">
          <button class="btn btn-info" @click="createProduct()">Create</button>
        </div>
        <div class="input-group mb-3 col-8 ">
          <input type="text" class="form-control rounded-0" placeholder="Search Product" v-model="search">
          <button @click="view" class="btn btn-secondary rounded-0" type="button" id="button-addon2">Search</button>
        </div>
      </div>
    </div>
    <div class="row">
      <!--  Create and Edit Form -->
      <div class="col-md-4 mb-3">
        <div class="card">
          <div class="card-header">
            <h4>
              {{ isEdit ? 'Edit Product' : 'Create'}}
            </h4>
          </div>
          <div class="card-body">
            <alert-error :form="product" :message="message"></alert-error>
            <form @submit.prevent="isEdit ? update() : store()">
              <div class="form-group">
                <label>Name</label>
                <input type="text" name="name" class="form-control" v-model="product.name" :class="{ 'is-invalid': product.errors.has('name') }" />
                <has-error :form="product" field="name"></has-error>

              </div>
              <div class="form-group">
                <label>Price</label>
                <input type="number" class="form-control" name="price" v-model="product.price" :class="{ 'is-invalid': product.errors.has('price') }" />
                <has-error :form="product" field="price"></has-error>

              </div>
              <button type="submit" class="btn btn-primary">{{ isEdit ? 'Edit'  : 'Create' }}</button>
            </form>
          </div>
        </div>
      </div>
      <!-- Data Table -->
      <div class="col-md-8">
        <div class="table-responsive">
          <table class="table">
            <thead>
              <tr>
                <th scope="col">#</th>
                <th scope="col">Name</th>
                <th scope="col">Price</th>
                <th scope="col" colspan="2" class="text-center">Action</th>       </tr>
            </thead>
            <tbody>
              <tr v-for="product in products.data" :key="products.id">
                <th scope="row">
                  {{product.id}}
                </th>
                <td>{{product.name}}</td>
                <td>{{product.price}}$</td>
                <td class="text-center">
                  <button class="btn btn-success" @click="edit(product)">Edit</button>
                </td>
                <td class="text-center">
                  <button class="btn btn-danger" @click="destroy(product.id)">Delete</button>
                </td>
              </tr>
            </tbody>
          </table>
          <!-- Pagination  -->

          <pagination :data="products" @pagination-change-page="view"></pagination>
        </div>
      </div>
    </div>
  </div>
</template>
<script>

  export default {
    name: "ProductComponent",
    data() {
      return {
        isEdit: false,
        products: {},
        product: new Form({
          id: '',
          name: '',
          price: ''
        }),
        search: '',
        message: ''
      }
    },
    methods: {
      view(page = 1) {
        axios.get('/api/products?page=' +  page + '&search=' + this.search)
        .then(response=> {
          this.products = response.data
        });
      },
      createProduct() {
        this.product.reset();
        this.isEdit = false;

      },
      store() {
        this.product.clear();
        this.product.post('/api/products')
        .then(response=> {
          this.view();
          this.product.reset();
          const Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 3000,
            timerProgressBar: true,
            didOpen: (toast) => {
              toast.addEventListener('mouseenter', Swal.stopTimer)
              toast.addEventListener('mouseleave', Swal.resumeTimer)
            }
          })

          Toast.fire({
            icon: 'success',
            title: 'Created Successfully'
          })
        })
        .catch(errors=> {
          this.message = errors.response.data.message;
        })
      },
      edit(product) {
        this.product.clear();
        this.isEdit = true;
        this.product.fill(product)
      },
      update() {
        this.product.put(`/api/products/${this.product.id}`)
        .then(response=> {
          this.view();
          this.product.reset();
          const Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 3000,
            timerProgressBar: true,
            didOpen: (toast) => {
              toast.addEventListener('mouseenter', Swal.stopTimer)
              toast.addEventListener('mouseleave', Swal.resumeTimer)
            }
          })

          Toast.fire({
            icon: 'success',
            title: 'Updated Successfully'
          })
        })
      },
      destroy(id) {
        Swal.fire({
          title: 'Are you sure?',
          icon: 'warning',
          showCancelButton: true,
          confirmButtonColor: '#3085d6',
          cancelButtonColor: '#d33',
          confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
          if (result.isConfirmed) {
            Swal.fire(
              'Deleted!',
              'success'
            );
            axios.delete(`/api/products/${id}`)
            .then(res=> {
              this.view();
            });
            // Toast
            const Toast = Swal.mixin({
              toast: true,
              position: 'top-end',
              showConfirmButton: false,
              timer: 3000,
              timerProgressBar: true,
              didOpen: (toast) => {
                toast.addEventListener('mouseenter', Swal.stopTimer)
                toast.addEventListener('mouseleave', Swal.resumeTimer)
              }
            })

            Toast.fire({
              icon: 'success',
              title: 'Deleted Successfully'
            })
          }
        })
      },
    },
    created() {
      this.view();
    }
  }
  </script>