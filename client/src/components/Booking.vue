<template>
  <v-container>
    <h1>Booking Information</h1>
    <v-form>
      <p>Creation Date: {{ bookingInfo.creation_date }}</p>
      <p>Booking Date: {{ bookingInfo.booking_date }}</p>
      <p>Start Time: {{ bookingInfo.start_time }}</p>
      <p>End Time: {{ bookingInfo.end_time }}</p>
      <p>Status: {{ bookingInfo.status }}</p>
      <p>Customer: {{ bookingInfo.customer_firstname }}&nbsp;{{ bookingInfo.customer_lastname }}</p>
      <p>Worker: {{ bookingInfo.worker_firstname }}&nbsp;{{ bookingInfo.worker_lastname }}</p>
      <br />
      <template v-if="bookingInfo.status == 'ongoing' || bookingInfo.status == 'completed'">
        <v-text-field :disabled="activeRole == 'Worker'" label="Comments" v-model="bookingInfo.comments"></v-text-field>
        <p>Rating ({{ bookingInfo.rating || 0 }})</p>
        <v-rating :readonly="activeRole == 'Worker'" color="orange lighten-1" label="Rating" v-model="bookingInfo.rating">Rating</v-rating>
      </template>
      <br />

      <v-btn @click="goBack" class="mr-1">Back</v-btn>
      <v-btn @click="updateBookingStatus('scheduled')" v-if="bookingInfo.status == 'pending' && activeRole == 'Worker'" dark class="mr-1 blue">Approve</v-btn>
      <v-btn @click="updateBookingStatus('rejected')" v-if="bookingInfo.status == 'pending' && activeRole == 'Worker'" dark class="mr-1 red">Reject</v-btn>
      <v-btn @click="updateBookingStatus('ongoing')" v-if="bookingInfo.status == 'scheduled' && activeRole == 'Customer'" class="mr-1 orange">Start Job</v-btn>
      <v-btn
        @click="updateBookingStatus('completed')"
        v-if="bookingInfo.status == 'ongoing' && activeRole == 'Customer'"
        class="mr-1 success"
        :disabled = "bookingInfo.rating == '' || bookingInfo.comments == ''"
      >Mark as Complete</v-btn>
    </v-form>
  </v-container>
</template>
<script>
export default {
  data() {
    return {
      bookingInfo: {}
    };
  },
  beforeMount: function() {
    this.getBookingInfo();
  },
  computed : {
    activeRole () {
      return this.$store.getters["user/getActiveRole"];
    }
  },
  methods: {
    goBack() {
      this.$router.go(-1);
    },
    getBookingInfo() {
      const bookingID = this.$route.params.id;
      this.$store
        .dispatch("booking/getByID", { id: bookingID })
        .then(results => {
          console.log(results.data);
          this.bookingInfo = results.data;
          if(typeof this.bookingInfo.rating != 'number'){
            this.bookingInfo.rating = parseInt(this.bookingInfo.rating);
          }

        })
        .catch(error => {
          console.log(error);
        });
    },
    updateBookingStatus(bookingStatus){

      this.bookingInfo.status = bookingStatus;

      this.$store.dispatch("booking/update",this.bookingInfo)
      .then(results => {
        console.log(results);
        this.$store.commit("setSnackBarText","Booking has been successfully updated!");
        this.$store.commit("showSnackBar");
        this.$router.go(-1);
      })
      .catch(error => {
         console.log(error);
         this.$store.commit("setSnackBarText","Error was encounted when updating this booking.");
         this.$store.commit("showSnackBar");
      })

    }
  }
};
</script>