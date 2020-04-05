<template>
  <v-container>
    <v-row>
      <v-col>
        <v-data-table :headers="headers" :items="items" sort-by="booking_date" class="elevation-1">
          <template v-slot:item.actions="{ item }">
            <v-icon small class="mr-2" @click="editItem(item.id)">mdi-pencil</v-icon>
            <v-icon small @click="deleteItem(item.id)">mdi-delete</v-icon>
          </template>
          <template v-slot:no-data>
            <v-btn color="primary" @click="initialize">Reset</v-btn>
          </template>
        </v-data-table>
      </v-col>
    </v-row>
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
        sortable: false,
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
    }
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
    deleteItem(bookingID) {
      const params = { id: bookingID };

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
          this.refreshItems();
        })
        .catch(error => {
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
    }
  }
};
</script>