<template>
  <v-container>
    <v-row class="text-center">
      <v-col cols="12">
        <v-img :src="require('../assets/logo.svg')" class="my-3" contain height="200" />
      </v-col>

      <v-col class="mb-4">
        <h1 class="display-2 font-weight-bold mb-3">Errunds</h1>
        Welcome {{name}}!

        <p class="subheading font-weight-regular"></p>
      </v-col>

      <v-col class="mb-5" cols="12">
        <v-row justify="center">
          <v-btn @click="createUser">Create User</v-btn>
        </v-row>
      </v-col>

      <v-col class="mb-5" cols="12">
        <v-row justify="center">
          <v-btn @click="createBooking">New Booking</v-btn>
        </v-row>
      </v-col>

      <v-col class="mb-5" cols="12">
        <v-row justify="center">
          <v-btn @click="signIn">Sign-In</v-btn>
        </v-row>
      </v-col>

    </v-row>
  </v-container>
</template>

<script>
export default {
  name: "Dashboard",
  data: () => ({
    currentUser:"",
    name:""
  }),
  mounted: function(){
    this.name = this.$route.params.name;
  },
  methods: {
    createUser() {
      this.$store.dispatch("user/create");
    },
    createBooking() {
      this.$store.dispatch("booking/create");
    },
    signIn() {
      this.$router.push('/login');
    }
  }
};
</script>
