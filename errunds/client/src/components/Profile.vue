<template>
  <v-container>
    <v-row>
      <v-col class="mb-4">
        <v-form>
        <p>Username: {{ userInfo.username }}</p>
        <v-text-field label="First Name" v-model="userInfo.first_name"></v-text-field>
        <v-text-field label="Last Name" v-model="userInfo.last_name"></v-text-field>
        <v-text-field label="Address" v-model="userInfo.address"></v-text-field>
        <v-text-field label="Email" v-model="userInfo.email"></v-text-field>
        <v-text-field label="Contact" v-model="userInfo.contact"></v-text-field>

        <div class="d-flex flex-row">
          <v-btn @click="goBack">Back</v-btn>
          <v-btn @click="updateProfile" class="success">Update</v-btn>
        </div>
        </v-form>
      </v-col>
    </v-row>
  </v-container>
</template>
<script>
export default {
    data(){
        return {
          userInfo : {}
        }
    },
    computed: {
        activeUser () {
            return this.$store.getters["user/getActiveUser"];
        }
    },
    beforeMount: function(){
      const activeUser = this.$store.getters["user/getActiveUser"];
      console.log(activeUser);
      Object.assign(this.userInfo,activeUser);

    },
    methods:{
      goBack() {
        this.$router.go(-1);
      },
      updateProfile() {
        console.log(this.userInfo);
        this.$store.dispatch("user/update",this.userInfo)
        .then(results => {
          if(results){
            this.$store.commit("user/setActiveUser",this.userInfo);
            this.$store.commit("setSnackBarText","Your profile has been successfully updated!");
            this.$store.commit("showSnackBar");
            this.$router.go(-1);
          }
        })
        .catch(error => {
          this.$store.commit("setSnackBarText","Error was encounted when updating your profile.");
          this.$store.commit("showSnackBar");
          console.log(error);
        });
      }
    }
}
</script>