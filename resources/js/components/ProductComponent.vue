<template>
  <div class="container my-5">
    <div class="row">
      <div class="col-md-4 offset-md-8">
        <div class="input-group mb-3">
          <input type="text" class="form-control rounded-0" placeholder="Search Product">
          <button class="btn btn-secondary rounded-0" type="button" id="button-addon2">Search</button>
        </div>
      </div>
    </div>
    <div class="row">
      <!--  Create Form -->
      <div class="col-md-4 mb-3">
        <div class="card">
          <div class="card-header">
            <h4>
              Create New Product
            </h4>
          </div>
          <div class="card-body">
            <form>
              <div class="form-group">
                <label>Name</label>
                <input type="text" class="form-control" />
              </div>
              <div class="form-group">
                <label>Price</label>
                <input type="number" class="form-control" />
              </div>
              <button type="submit" class="btn btn-primary">Create</button>
            </form>
          </div>
        </div>
      </div>
      <!--vData Table -->
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
              <tr v-for="product in products" :key="products.id">
                <th scope="row">
                  {{product.id}}
                </th>
                <td>{{product.name}}</td>
                <td>{{product.price}}$</td>
                <td class="text-center">
                  <button class="btn btn-success">Edit</button>
                </td>
                <td class="text-center">
                  <button class="btn btn-danger">Delete</button>
                </td>
              </tr>
            </tbody>
          </table>

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
        products: []
      }
    },
    methods: {
      view() {
        axios.get('/api/products')
        .then(response=> {
          this.products = response.data
        })
      }
    },
    created() {
      this.view();
    }
  }
  </script>