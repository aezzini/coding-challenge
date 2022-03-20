<template>
    <div>
        <h3 class="text-center">{{product_id?'Edit':'Add'}} Product</h3>
        <div class="row">
            <div class="col-md-6">
                <form @submit.prevent="submit" enctype="multipart/form-data">
                    <div class="form-group">
                        <label>Name</label>
                        <input type="text" required class="form-control" v-model="product.name">
                    </div>
                    <div class="mt-2 form-group">
                        <label>Description</label>
                        <textarea class="form-control" v-model="product.description">
                        </textarea>
                    </div>
                    <div class="mt-2 form-group">
                        <label>Price</label>
                        <input step="0.01" type="number" class="form-control" v-model="product.price">
                    </div>
                    <div class="mt-2 form-group">
                        <label>Categories</label>
                        <select multiple class="form-control" v-model="product.categories">
                            <option v-for="option in categories" v-bind:value="option.id">
                                {{ option.name }}
                            </option>
                        </select>
                    </div>
                    <div class="mt-2 form-group">
                        <label>Image</label>
                        <a target="_blank" v-if="product.image" :href="'/api/product/image/'+product.image"><img v-if="product.image" width="40" :src="'/api/product/image/'+product.image" /></a>
                        <input type="file" class="form-control" v-on:change="onFileChange" name="image" accept="image/x-png,image/gif,image/jpeg"/>
                    </div>
                    <button type="submit" class="mt-3 btn btn-primary">{{product_id?'Edit':'Add'}} Product</button>
                </form>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                product_id: null,
                product: {
                    name: null,
                    description: null,
                    price: null,
                    categories: [],
                    image: null
                },
                image: null,
                categories: {},
            }
        },
        created () { 
            // Get categories list
            this.axios
            .get(`/api/categories?without_items=t`, {
                    validateStatus: function (status) {
                        return status < 500; // Resolve only if the status code is less than 500
                    }
                })
            .then((response) => {
                if(response.data.status != 200){
                    this.$notify({
                        group: 'foo',
                        type: 'error',
                        title: 'Error',
                        text: response.data.error
                    });
                }
                else{
                    this.categories = response.data.data
                }
            })

            if(this.$route.params.id){
                // Get product info
                this.product_id = this.$route.params.id
                this.axios
                .get(`/api/product/edit/${this.$route.params.id}`, {
                    validateStatus: function (status) {
                        return status < 500; // Resolve only if the status code is less than 500
                    }
                })
                .then((response) => {
                    if(response.data.status != 200){
                        this.$notify({
                            group: 'foo',
                            type: 'error',
                            title: 'Error',
                            text: response.data.error
                        });
                    }
                    else{
                        var product = response.data.data[0]
                        var categories = [];
                        product.categories.map(function(cat){
                            categories.push(cat.id);
                        })
                        delete this.product["categories"];
                        product["categories"] = categories;
                        this.product = product;
                    }
                })
            }
            return null 
        },
        methods: {
            onFileChange(e) {
                this.image = e.target.files[0];
            },
            submit() {
                var url_ = "add"
                if(this.product_id)
                    url_ = "update/"+this.product_id
                const config = {
                    headers: {
                        'content-type': 'multipart/form-data;',
                    }
                }
                let formData = new FormData();
                if(this.image)
                    formData.append('image', this.image);
                for (var z in this.product) {
                    if(z!="image" && this.product[z] && this.product[z]!="" && this.product[z]!=undefined)
                        formData.append(z, this.product[z]);
                }
                var instance = axios.create({
                    validateStatus: function (status)
                    {
                        return status < 500;
                    }
                });
                instance
                .post('/api/product/'+url_, formData, config)
                .then(response => {
                    if(response.data.status != 200){
                        this.$notify({
                            group: 'foo',
                            type: 'error',
                            title: 'Error',
                            text: response.data.error
                        });
                    }
                    else{
                        this.$notify({
                            group: 'foo',
                            type: 'success',
                            title: 'Success',
                            text: 'Product saved successfully...'
                        });
                        this.$router.push({name: 'productList'})
                    }
                })
                .catch(error => console.log(error))
                .finally(() => this.loading = false)
            }
        }
    }
</script>