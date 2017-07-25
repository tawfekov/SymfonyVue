<<template>
  <div class="container">
    <nav class="navbar is-transparent">
      <div class="navbar-brand">
        <a class="navbar-item" href="#">Symfony</a>
        <div class="navbar-burger burger" data-target="vue-menu">
          <span></span>
          <span></span>
          <span></span>
        </div>
      </div>
      <div id="vue-menu" class="navbar-menu">
        <div class="navbar-start">
          <router-link tag='div' to="/" class="navbar-item">Home</router-link>
          <router-link tag='div' to="hello" class="navbar-item">Hello</router-link>
          <router-link tag='div' to="demo" class="navbar-item">Demo</router-link>
          <router-link tag='div' to="notfound" class="navbar-item">Not Found URL</router-link>
        </div>
      </div>
    </nav>
    <div>
      <router-view></router-view>
    </div>
  </div>
</template>

<script>
  export default {
    name: 'app'
  }
</script>