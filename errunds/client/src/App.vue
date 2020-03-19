<template>
  <v-app>
    <v-app-bar app color="primary" dark v-if="$route.path !='/login'">
      <div class="d-flex align-center">
        <div class="headline">Errunds</div>
      </div>

      <v-spacer></v-spacer>

      <router-link to="/login">Login</router-link>
    </v-app-bar>

    <v-content>
      <router-view></router-view>
    </v-content>
  </v-app>
</template>

<script>
export default {
  name: "App",

  data: () => ({
    //
  })
};
</script>
