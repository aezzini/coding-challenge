<template>
    <div class="container">
        <div class="text-center mt-3 mb-3">
            <a href="http://nextmedia.ma/" target="_blank"><img src="http://nextmedia.ma/assets/img/favicon.ico"></a><br>
            <span class="text-secondary">Next Media - Tech challenge by <b>Ayoub Ezzini</b></span>
        </div>

        <nav class="navbar navbar-expand-lg navbar-light bg-light">
            <div class="collapse navbar-collapse">
                <div class="navbar-nav">
                    <router-link to="/" class="nav-item nav-link active">Product List</router-link>
                    <router-link to="/product/handle" class="nav-item nav-link">Add Product</router-link>
                    <router-link to="/category/list" class="nav-item nav-link">Category List</router-link>
                    <router-link to="/category/handle" class="nav-item nav-link">Add Category</router-link>
                </div>
            </div>
            
            <notifications group="foo" />
        </nav>
        <br/>
        <router-view></router-view>
    </div>
</template>

<script>
    export default {}
</script>