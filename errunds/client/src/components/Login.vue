<template>
  <v-container fill-height>
    <v-row>
      <v-col align="center" justify="center" class="pa-6">
        <form style="max-width:400px">
          <v-img :src="require('../assets/errunds-logo.svg')"></v-img>
          <v-text-field v-model="name" label="Username"></v-text-field>
          <v-text-field v-model="password" label="Password" type="password"></v-text-field>
          <v-btn class="mr-4" @click="submit" width="100%" color="primary">Submit</v-btn>
        </form>
      </v-col>
    </v-row>
  </v-container>
</template>

<script>
export default {
  data: () => ({
    name: "",
    password: "",
    select: null,
    items: ["Customer", "Worker"],
    checkbox: false
  }),
  computed: {},

  methods: {
    submit() {

      this.$store.dispatch("user/authenticate",{
          username:this.name,
          password:this.password,
          vm:this
      });

    },
    clear() {
      this.$v.$reset();
      this.name = "";
      this.email = "";
      this.select = null;
      this.checkbox = false;
    }
  }
};
</script>