<template>
  <v-app>
    <v-app-bar app color="white" v-if="$route.path !='/login'">
      <div class="d-flex align-center">
        <v-img style="width:60px" :src="require('@/assets/logo-02.png')"></v-img>
        <div class="headline">Errunds</div>
      </div>

      <v-spacer></v-spacer>

       <v-icon size="x-large" @click="viewProfile" class="pa-3">mdi-account</v-icon>
       <v-icon size="x-large" @click="signOut" class="pa-3">mdi-logout</v-icon>
    </v-app-bar>

    <v-content>
      <router-view></router-view>
    </v-content>

    <SnackBar></SnackBar>
  </v-app>
</template>

<script>
import SnackBar from '@/components/SnackBar'

export default {
  name: "App",
  components: {
    SnackBar
  },
  data: () => ({
    //
  }),
  methods: {
    viewProfile() {
      this.$router.push('/profile');
    },
    signOut() {
      this.$store.dispatch('user/signOut',{vm:this});
    }
  }
};
</script>
