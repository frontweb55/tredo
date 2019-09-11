<template>
    <div id="main">
        <header id="header">
            <Menu></Menu>
        </header>
        <div id="content">
            <router-view></router-view>
        </div>
        <div id="loading" v-show="this.$root._data.is_loading">
            <img src="/img/loading.gif" alt="">
        </div>
    </div>
</template>
<script>
  import Menu from './components/Menu.vue'
  export default {
    components: {
      Menu
    }
  }
</script>
