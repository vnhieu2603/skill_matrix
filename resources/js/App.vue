
<template>
    <base-nav></base-nav>

    <RouterView />
</template>
  
<script>
import { RouterLink, RouterView } from 'vue-router'
import Nav from "./components/Nav.vue"
export default {

    components: {
        BaseNav: Nav,
    }

}
</script>
  
<style scoped></style>
  