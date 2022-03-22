<template>
  <div class="container p-3">
    <form :action="route" method="post"
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
  props: ['route'],
  data() {
    return {
      file: []
    }
  },
  methods: {
    loadData(event) {
      const files = event.target.files
      this.file = files[0]
    },
    importData() {
      var formData = new FormData();
      formData.append("json_file", this.file);
      axios
          .post('/api', formData, {
            headers: {
              'Content-Type': 'multipart/form-data'
            }
          })
          .then(response => {
            console.log(response.data)
          })
          .catch(error => {
            console.log(error)
            this.errored = true
          })
    }
  }
}
</script>

<style scoped>

</style>