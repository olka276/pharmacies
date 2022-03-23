<template>
  <div class="container p-3">
    <form action="" method=""
          enctype="multipart/form-data">
      <label class="custom-file-label">Eksport pliku</label>
      <div class="custom-file">

        <label for="type-select">Eksportuj jako:</label>

        <select id="type-select" @change="setSelectedValue">
          <option value="csv">.csv</option>
          <option value="json">.json</option>
        </select>

        <button type="button" @click="exportData(selected)"
                class="btn btn-primary btn-block mt-4">
          Pobierz
        </button>
      </div>

    </form>

  </div>
</template>

<script>
export default {
  name: "Exporter",
  props: ['data'],
  data() {
    return {
      selected: "csv",
      exported: "",
      mimeType: ""
    }
  },
  methods: {
    setSelectedValue(event) {
      this.selected = event.target.value;
    },

    exportData() {
      const params = {
        data: this.data,
        filetype: this.selected,
      }

      axios
          .post('/api/export', params)
          .then(response => {
            this.exported = response.data.data
            this.mimeType = response.data.mime_type
          })
          .then((res) => {
            return axios
                .get('/api/download?filename='+this.exported, )
                .then(res => {
                  var encodedUri = 'data:text/csv;charset=utf-8,' + encodeURI(res.data);
                  var link = document.createElement("a");
                  link.setAttribute("href", encodedUri);
                  link.setAttribute("download", "my_data.csv");
                  document.body.appendChild(link); // Required for FF

                  link.click(); // This will download the data file named "my_data.csv".
                })
                .catch(error => {
                  console.log(error.data)
                  this.errored = true
                })
              }

          )
          .catch(error => {
            console.log(error.data)
            this.errored = true
          })
    }
  }
}
</script>

<style scoped>

</style>