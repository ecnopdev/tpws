<template>
  <v-container>
    <v-row no-gutters>
      <v-col>
        <v-dialog v-model="search">
          <template v-slot:activator="{on}">
            <v-btn v-if="activeRole == 'Customer'" color="primary" v-on="on">New Booking</v-btn>
          </template>
          <v-card>
            <v-card-title>
              New booking
              <v-spacer></v-spacer>
              <v-icon @click="search = false">mdi-close</v-icon>
            </v-card-title>
            <v-card-text>
              <v-container>
                <v-row>
                  <v-col class="grey lighten-3">
                    <v-select
                      label="Job Type"
                      v-model="jobType"
                      :items="jobOptions"
                      required
                    ></v-select>
                    <DatePicker v-model="bookingDate"></DatePicker>
                    <div class="d-flex flex-row align-center">
                      <v-select label="Start Time" :items="timeOptions" v-model="startTime"></v-select>
                      <div class="mx-3">to</div>
                      <v-select label="End Time" :items="timeOptions" v-model="endTime"></v-select>
                    </div>
                    <v-btn @click="clearSearch">Clear</v-btn>
                    <v-btn class="success" @click="getWorkers">Search</v-btn>                
                  </v-col>
                  <v-col
                    v-if="this.bookingDate != '' && this.startTime != '' && this.endTime != '' && availableWorkers.length > 0"
                  >
                    <v-list subheader>
                      <v-subheader>Available Workers</v-subheader>
                      <template v-for="(worker,index) in availableWorkers">
                        <v-list-item :key="worker.id + worker.first_name">
                          <v-list-item-content>
                            <v-list-item-title>{{worker.first_name}}&nbsp;{{worker.last_name}}</v-list-item-title>
                            <v-list-item-subtitle class="d-flex flex-row align-center">
                              <v-rating color="orange lighten-1" readonly :value="worker.average_rating"></v-rating>
                              <span class="font-weight-bold">({{ worker.average_rating }})</span>
                            </v-list-item-subtitle>
                          </v-list-item-content>
                          <v-list-item-action>
                            <v-btn
                              :disabled="startTime == '' || endTime == ''"
                              @click="createBooking(worker.id)"
                              color="primary"
                            >Create Booking</v-btn>
                          </v-list-item-action>
                        </v-list-item>
                        <v-divider :key="index"></v-divider>
                      </template>
                    </v-list>
                  </v-col>
                </v-row>
              </v-container>
            </v-card-text>
          </v-card>
        </v-dialog>
      </v-col>
    </v-row>
    <v-row class="text-center" no-gutters>
      <v-col class="mb-5" cols="12">
        <v-row justify="center">
          <BookingList ref="bookingList"></BookingList>
        </v-row>
      </v-col>
    </v-row>
  </v-container>
</template>

<script>
import BookingList from "@/components/BookingList";
import DatePicker from "@/components/DatePicker";

export default {
  name: "Dashboard",
  components: {
    BookingList,
    DatePicker
  },
  data: () => ({
    currentUser: "",
    name: "",
    search: false,
    timeOptions: [],
    jobOptions: [],
    jobType: 1,
    bookingDate: new Date().toISOString().substr(0, 10),
    startTime: "",
    endTime: "",
    availableWorkers: []
  }),
  computed: {
    activeUser() {
      return this.$store.getters["user/getActiveUser"];
    },
    activeRole() {
      return this.$store.getters["user/getActiveRole"];
    },
    convertRating(strRating) {
      return parseInt(strRating);
    }
  },
  mounted: function() {
    this.name = this.$route.params.name;
    this.timeOptions = this.getTimeOptions();

    this.getJobOptions();
  },
  watch: {
    jobType () {
      this.availableWorkers = [];
    },
    bookingDate () {
      this.availableWorkers = [];
    },
    startTime (newVal){
      if (this.getNumTimeValue(newVal) > this.getNumTimeValue(this.endTime)){
        this.endTime = this.getAdjustedTime(newVal,1);
      }

      this.availableWorkers = [];
    },
    endTime (newVal){
      if(this.getNumTimeValue(newVal) < this.getNumTimeValue(this.startTime)){
        this.startTime = this.getAdjustedTime(newVal,-1);
      }

      this.availableWorkers = [];
    }
  },
  methods: {
    createBooking(workerID) {
      const params = {
        booking_date: this.bookingDate,
        start_time: this.startTime,
        end_time: this.endTime,
        worker_id: workerID
      };

      this.$store
        .dispatch("booking/create", params)
        .then(results => {
          console.log(results);
          this.$store.commit(
            "setSnackBarText",
            "New booking has been successfully created!"
          );
          this.$store.commit("showSnackBar");
          this.search = false;
          this.$refs.bookingList.refreshItems();
        })
        .catch(error => {
          console.log(error);
          this.$store.commit(
            "setSnackBarText",
            "Error encountered while creating your booking."
          );
          this.$store.commit("showSnackBar");
        });
    },
    signOut() {
      this.$store.commit("user/setActiveUser", null);
      this.$store.commit("user/setAccessToken", null);
      this.$router.push("/login");
    },
    getPaddedTimeValue(numTime){
      return numTime < 10 ? "0" + numTime : numTime
    },
    getNumTimeValue(strTime){
      if(strTime){
        return parseInt(strTime.replace(':',''));
      }else{
        return strTime;
      }  
    },
    getAdjustedTime(strTime,numAdjust){
      if(strTime){
        const splitTimes = strTime.split(':');
        const strHour = splitTimes[0];
        const strMin = splitTimes[1];
        const numHour = parseInt(strHour) + numAdjust;

        return this.getPaddedTimeValue(numHour) + ":" + strMin;
      }else{
        return strTime;
      }
    },
    getTimeOptions() {
      let timeOptions = [];
      for (var i = 0; i < 24; i++) {
        const timePadded = this.getPaddedTimeValue(i);
        timeOptions.push(`${timePadded}:00`);
        timeOptions.push(`${timePadded}:30`);
      }
      return timeOptions;
    },
    getWorkers() {
      this.$store
        .dispatch("worker/getAll", {
          bookingDate: this.bookingDate,
          startTime: this.startTime,
          endTime: this.endTime
        })
        .then(results => {
          console.log(results);
          this.availableWorkers = [];
          results.data.data.forEach(item => {
            item.average_rating = parseInt(item.average_rating);
            //filter by job
            console.log(item);
            console.log("FILTER JOB TYPE: " + this.jobType);
            if(this.jobType == item.job_id){
              this.availableWorkers.push(item);
            } 
          });
        })
        .catch(error => {
          console.log(error);
        });
    },
    getJobOptions() {
      this.$store
        .dispatch("job/getAll")
        .then( results => {
          results.data.data.forEach(jobItem => {
            this.jobOptions.push({
              text: jobItem.name,
              value: jobItem.id
            });
          })
          
        })
        .catch( error => {
          console.log(error);
          this.jobOptions = [
            {text:"Laundry",value:1}
          ];
        })

    },
    clearSearch(){
      this.availableWorkers = [];
    }

  }
};
</script>
