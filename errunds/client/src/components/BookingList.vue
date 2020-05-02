<template>
  <v-container>
    <v-row>
      <v-col>
        <v-data-table
          :headers="headers"
          :items="items"
          sort-by="booking_date"
          :sort-desc="true"
          class="elevation-1"
        >
          <template v-slot:item.status="{ item }">
            <v-chip :color="getColor(item.status)" dark>{{ item.status }}</v-chip>
          </template>
          <template v-slot:item.actions="{ item }">
            <v-icon small class="mr-2" @click="editItem(item.id)">mdi-pencil</v-icon>
            <v-icon small v-if="item.status == 'pending'" @click="checkDelete(item.id)">mdi-delete</v-icon>
          </template>
          <template v-slot:no-data>
            <v-btn color="primary" @click="initialize">Reset</v-btn>
          </template>
        </v-data-table>
      </v-col>
    </v-row>

    <v-dialog v-model="dialog" persistent max-width="320">
      <v-card>
        <v-card-title class="headline">Cancel / Delete Booking</v-card-title>
        <v-card-text>Are you sure you want to delete this booking request?</v-card-text>
        <v-card-actions>
          <v-spacer></v-spacer>
          <v-btn color="green darken-1" text @click="dialog = false">No</v-btn>
          <v-btn color="green darken-1" text @click="deleteItem">Yes</v-btn>
        </v-card-actions>
      </v-card>
    </v-dialog>

  </v-container>
</template>
<script>
export default {
  data: () => ({
    dialog: false,
    headers: [
      {
        text: "Booking Date",
        align: "start",
        sortable: true,
        value: "booking_date"
      },
      { text: "Worker Name", value: "worker_fullname" },
      { text: "Start Time", value: "start_time" },
      { text: "End Time", value: "end_time" },
      { text: "Status", value: "status" },
      { text: "Actions", value: "actions", sortable: false }
    ],
    items: [],
    editedIndex: -1,
    editedItem: {
      name: "",
      calories: 0,
      fat: 0,
      carbs: 0,
      protein: 0
    },
    defaultItem: {
      name: "",
      calories: 0,
      fat: 0,
      carbs: 0,
      protein: 0
    },
    itemToBeDeleted:-1,
  }),
  computed: {
    activeUser() {
      return this.$store.getters["user/getActiveUser"];
    }
  },
  mounted: function() {
    this.refreshItems();
  },
  methods: {
    save() {},
    editItem(bookingID) {
      this.$router.push(`/booking/${bookingID}`);
    },
    checkDelete(bookingID) {
      this.itemToBeDeleted = bookingID;
      this.dialog = true;
    },  
    deleteItem() {
      const params = { id: this.itemToBeDeleted };
      console.log(params);

      this.$store
        .dispatch("booking/delete", params)
        .then(results => {
          console.log(results);
          this.$store.commit(
            "setSnackBarText",
            "Booking successfully deleted!"
          );
          this.$store.commit("showSnackBar");
          this.search = false;
          this.dialog = false;
          this.refreshItems();
        })
        .catch(error => {
          this.dialog = false;
          console.log(error);
          this.$store.commit(
            "setSnackBarText",
            "Error encountered while deleting your booking."
          );
          this.$store.commit("showSnackBar");
        });
    },
    initialize() {},
    refreshItems() {
      this.items = [];
      this.$store
        .dispatch("booking/getAll", this.activeUser)
        .then(results => {
          results.data.data.forEach(item => {
            item.worker_fullname = `${item.worker_firstname} ${item.worker_lastname}`;
            this.items.push(item);
          });
        })
        .catch(error => {
          console.log(error);
        });
    },
    getColor(status) {
      if (status == "pending") return "red";
      if (status == "rejected") return "blue";
      if (status == "scheduled") return "blue";
      if (status == "ongoing") return "orange";

      return "green";
    }
  }
};
</script>