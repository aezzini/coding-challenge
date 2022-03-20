<template>
    <div>
        <h3 class="text-center">Categories</h3><br/>
        
        <b-table
            striped
            hover
            :items="categories"
            :fields="fields"
            :current-page="currentPage"
            :per-page="0"
            label-sort-asc=""
            label-sort-desc=""
            label-sort-clear=""
        >

            <template v-slot:cell(parent_category_id)="row">
                <span v-if="row.item.parent">{{ row.item.parent.name }}</span>
            </template>

            <template v-slot:cell(action)="data">
                <router-link :to="{name: 'categoryHandle', params: { id: data.item.id }}">
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
                categories: [],
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
                        key: "parent_category_id",
                        label: "Parent Category",
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
                .delete(`/api/category/delete/${data.item.id}`, {
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
                            text: 'Category deleted successfully...'
                        });
                        this.buildAndRun();
                    }
                });
                
            },
            buildAndRun(){
                this.params = `page=${this.currentPage}&limit=${this.recordsPerPage}&order=${this.currentSort}&orderDirection=${this.currentSortDir}`;
                this.loadCategories();
                
            },
            loadCategories(){
                this.isLoading = true;
                this.axios
                .get('/api/categories?'+this.params, {
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
            formatList(items){
                this.categories = items;
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