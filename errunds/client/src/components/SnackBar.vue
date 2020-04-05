<template>
    <v-snackbar
      :value="isVisible"
    >
      {{ text }}
      <v-btn
        color="red"
        text
        @click="hideSnackBar"
      >
        Close
      </v-btn>
    </v-snackbar>
</template>
<script>
export default {
    computed : {
        text () {
            return this.$store.getters.getSnackBarText;
        },
        isVisible () {
            console.log(this.$store.getters);
            return this.$store.getters.checkSnackBarVisible;
        }
    },
    methods : {
        hideSnackBar() {
            this.$store.commit('hideSnackBar');
        }
    }
}
</script>