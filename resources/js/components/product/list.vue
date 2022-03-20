<template>
    <div>
        <h3 class="text-center">Products</h3><br/>
        
        <div class="col-md-4">
            <div class="mb-4 form-group">
                <label>Filter by Category</label>
                <select v-on:change="buildAndRun()" class="form-control" v-model="category">
                    <option value=""></option>
                    <option v-for="option in categories" v-bind:value="option.id">
                        {{ option.name }}
                    </option>
                </select>
            </div>
        </div>
        <b-table
            striped
            hover
            :items="products"
            :fields="fields"
            :current-page="currentPage"
            :per-page="0"
            label-sort-asc=""
            label-sort-desc=""
            label-sort-clear=""
        >
            <template v-slot:cell(image)="row">
                <img v-if="row.item.image" height="40" :src="'/api/product/image/'+row.item.image"/>
            </template>

            <template v-slot:cell(categories)="row">
                <span v-html="row.item.categories"></span>
            </template>

            <template v-slot:cell(action)="data">
                <router-link :to="{name: 'productHandle', params: { id: data.item.id }}">
                    <b-button size="sm" variant="info"> Edit </b-button>
                </router-link>
                <b-button size="sm" variant="danger" @click="deleteRecord(data)"> Delete </b-button>
            </template>
        </b-table>
        <b-pagination
            v-model="currentPage"
            :total-rows="totalPages"
            :per-page="recordsPerPage"
        >
        </b-pagination>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                products: [],
                categories: [],
                category: 0,
                currentPage: 1,
                totalPages: 1,
                recordsPerPage: 5,
                currentSort:'id',
                currentSortDir:'asc',
                isLoading: false,
                fields: [
                    {
                        key: "id",
                        label: "ID",
                        sortable: false,
                        sortDirection: "desc",
                    },
                    {
                        key: "name",
                        label: "Name",
                        sortable: true,
                        class: "text-center",
                    },
                    {
                        key: "description",
                        label: "Description",
                        sortable: false,
                        image: true,
                    },
                    {
                        key: "price",
                        label: "Price",
                        sortable: true,
                        image: true,
                    },
                    {
                        key: "image",
                        label: "Image",
                        sortable: false,
                        image: true,
                    },
                    {
                        key: "categories",
                        label: "Categories",
                        sortable: false,
                    },
                    {
                        key: "action",
                        label: "Actions",
                    },
                ],
                params: "",
            }
        },
        created() {
            this.loadCategories();
            this.buildAndRun();
        },
        methods: {
            sort:function(s) {
                if(s === this.currentSort) {
                    this.currentSortDir = this.currentSortDir==='asc'?'desc':'asc';
                }
                this.currentSort = s;
                this.buildAndRun();
            },
            deleteRecord(data){
                this.axios
                .delete(`/api/product/delete/${data.item.id}`, {
                    validateStatus: function (status) {
                        return status < 500; // Resolve only if the status code is less than 500
                    }
                })
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
                            text: 'Product deleted successfully...'
                        });
                        this.buildAndRun();
                    }
                });
            },
            buildAndRun(){
                this.params = `page=${this.currentPage}&limit=${this.recordsPerPage}&order=${this.currentSort}&orderDirection=${this.currentSortDir}&category=${this.category}`;
                this.loadProducts();
            },
            loadProducts(){
                this.isLoading = true;
                this.axios
                .get('/api/products?'+this.params, {
                    validateStatus: function (status) {
                        return status < 500; // Resolve only if the status code is less than 500
                    }
                })
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
                        this.totalPages = response.data.data.total
                        this.formatList(response.data.data.items);
                        this.isLoading = false;
                    }
                });
            },
            loadCategories(){
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
            },
            formatList(items){
                this.products = [];
                for(var i = 0; i < items.length; i++){
                    var row = items[i];
                    var categories = [];
                    row.categories.map(function(cat){
                        categories.push(cat.name);
                    })
                    row.categories = categories.join("<br/>");
                    this.products.push(row);
                }
            }
        },
        watch: {
            currentPage: {
                handler: function (value) {
                    this.currentPage = value;
                    this.buildAndRun();
                }
            },
        },
    }
</script>