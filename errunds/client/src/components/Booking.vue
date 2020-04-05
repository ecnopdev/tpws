<template>
    <v-container>
    <h1>Booking Information</h1>
    <v-form>
        <p>
            Creation Date: {{ bookingInfo.creation_date }}
        </p>
        <p>
            Booking Date: {{ bookingInfo.booking_date }}
        </p>
        <p>
            Start Time: {{ bookingInfo.start_time }}
        </p>
         <p>
            End Time: {{ bookingInfo.end_time }}
        </p>
         <p>
            Status Time: {{ bookingInfo.status }}
        </p>
        <p>
            Worker: {{ bookingInfo.worker_firstname }}&nbsp;{{ bookingInfo.worker_lastname }}
        </p>
        <v-text-field label="Comments" v-model="bookingInfo.comments"></v-text-field>
        <p>Rating</p>
        <v-rating label="Rating" v-model="bookingInfo.rating">Rating</v-rating>
        <v-btn @click="goBack">Back</v-btn>
        <v-btn @click="goBack" class="success">Update</v-btn>
    </v-form>
    </v-container>
</template>
<script>
export default {
    data() {
        return {
            bookingInfo:{}
        };
    },
    beforeMount : function(){ 
        this.getBookingInfo();
    },
    methods : {
        goBack() {
            this.$router.go(-1);
        },
        getBookingInfo(){
            const bookingID = this.$route.params.id;
            this.$store.dispatch("booking/getByID",{id:bookingID})
            .then(results => {
                console.log(results.data);
                this.bookingInfo = results.data;
            })
            .catch(error => {
                console.log(error);
            })
           
        }
    }
}
</script>