<template>
    <div>
        <h3 class="text-center">{{category_id?'Edit':'Add'}} Category</h3>
        <div class="row">
            <div class="col-md-6">
                <form @submit.prevent="submit" enctype="multipart/form-data">
                    <div class="form-group">
                        <label>Name</label>
                        <input type="text" required class="form-control" v-model="category.name">
                    </div>
                    <div class="form-group mt-2">
                        <label>Parent category</label>
                        <select class="form-control" v-model="category.parent_category_id">
                            <option v-for="option in categories " v-bind:value="option.id" v-if="!category_id || option.value!=category_id">
                                {{ option.name }}
                            </option>
                        </select>
                    </div>
                    <button type="submit" class="mt-2 btn btn-primary">{{category_id?'Edit':'Add'}} Category</button>
                </form>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                category_id: null,
                category: {},
                categories: {},
            }
        },
        created () { 
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
                this.category_id = this.$route.params.id
                this.axios
                .get(`/api/category/edit/${this.$route.params.id}`, {
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
                        this.category = response.data.data
                    }
                })
            }
            return null 
        },
        methods: {
            submit() {
                var url_ = "add"
                if(this.category_id)
                    url_ = "update/"+this.category_id

                let formData = new FormData();
                for (var z in this.category) {
                    if(this.category[z])
                        formData.append(z, this.category[z]);
                }

                this.axios
                .post('/api/category/'+url_, formData, {
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
                            text: 'Category saved successfully...'
                        });
                        this.$router.push({name: 'categoryList'})
                    }
                })
                .catch(error => console.log(error))
                .finally(() => this.loading = false)
            }
        }
    }
</script>