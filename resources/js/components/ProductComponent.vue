<template>
  <div class="container my-5">
    <div class="row">
      <div class="col-md-8 offset-md-4 d-flex justify-content-between">
        <div class="col-4">
          <button class="btn btn-info" @click="store()">Create</button>
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
            <form @submit.prevent="isEdit ? update() : store()">
              <div class="form-group">
                <label>Name</label>
                <input type="text" name="name" class="form-control" v-model="product.name" />
              </div>
              <div class="form-group">
                <label>Price</label>
                <input type="number" class="form-control" name="price" v-model="product.price" />
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
        product: {
          id: '',
          name: '',
          price: ''
        },
        search:''
      }
    },
    methods: {
      view(page = 1) {
        axios.get('/api/products?page=' +  page + '&search=' + this.search)
        .then(response=> {
          this.products = response.data
        });
      },
      store() {
        this.isEdit = false;
        axios.post('/api/products', this.product)
        .then(response=> {
          this.view();
          this.product = {
            name: '',
            price: ''
          }
        })
      },
      edit(product) {
        this.isEdit = true;
        this.product.id = product.id,
        this.product.name = product.name,
        this.product.price = product.price
      },
      update() {
        axios.put(`/api/products/${this.product.id}`, this.product)
        .then(response=> {
          this.view();
          this.product = {
            name: '',
            price: ''
          };
        })
      },
      destroy(id) {
        if (!confirm("Are You Sure To Delete?")) {
          return;
        }
        axios.delete(`/api/products/${id}`)
        .then(res=> {
          this.view();
        })
      },
    },
    created() {
      this.view();
    }
  }
  </script>