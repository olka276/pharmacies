<template>
  <div class="container p-5 d-flex justify-content-end">
    <div v-if="errored" class="alert alert-danger" role="alert">
      Wystąpił błąd importu pliku. Upewnij się, że plik ma właściwy format.
    </div>
    <form action="" method=""
          enctype="multipart/form-data">
      <label class="custom-file-label">Import pliku</label>
      <div class="custom-file">
        <input type="file" class="custom-file-input" @change="loadData">
        <button @click="importData" class="btn btn-primary btn-block mt-4">
          Załaduj
        </button>
      </div>

    </form>

  </div>
</template>

<script>
export default {
  name: "Uploader",
  data() {
    return {
      file: [],
      errored: false
    }
  },
  methods: {
    loadData(event) {
      const files = event.target.files
      this.file = files[0]
    },
    importData(event) {
      var formData = new FormData();
      formData.append("json_file", this.file);
      if (event) {
        event.preventDefault()
      }
      axios
          .post('/api', formData, {
            headers: {
              'Content-Type': 'multipart/form-data'
            }
          })
          .then(response => {
            this.errored = false
            window.location.reload(true);
          })
          .catch(error => {
            // console.log(error)
            if(error.status === 500 ) {
              console.log('500')
            }
           if(error.status === 422 ) {
              console.log('422')
            }

            this.errored = true
          })
    }
  }
}
</script>

<style scoped>

</style>