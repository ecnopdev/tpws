<template>
  <v-container class="pa-3">
    <form>
      <v-text-field v-model="name" label="Username"></v-text-field>
      <v-text-field v-model="email" label="Password" type="password"></v-text-field>
      <v-select v-model="select" :items="items" label="User Type" required></v-select>

      <v-btn class="mr-4" @click="submit">Login</v-btn>
      <v-btn @click="clear">clear</v-btn>
    </form>
  </v-container>
</template>

<script>
export default {
  data: () => ({
    name: "",
    email: "",
    select: null,
    items: ["Customer", "Worker"],
    checkbox: false
  }),
  computed: {},

  methods: {
    submit() {
      this.$router.push("/");
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