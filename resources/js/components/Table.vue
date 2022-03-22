<template>
  <div class="container">
   <table class="table">
      <thead>
      <tr>
        <th scope="col">Id</th>
        <th scope="col">Nazwa</th>
        <th scope="col">Kod pocztowy</th>
        <th scope="col">Ulica</th>
        <th scope="col">Miejscowość</th>
        <th scope="col">Współrzędne geograficzne</th>
      </tr>
      </thead>
      <tbody>
      <tr v-for="pharmacy in pharmacies">
        <th scope="row"> {{ pharmacy.id }}</th>
        <td> {{ pharmacy.nazwa }}</td>
        <td> {{ pharmacy.kod_pocztowy }}</td>
        <td> {{ pharmacy.ulica }}</td>
        <td> {{ pharmacy.miejscowosc }}</td>
        <td> {{ pharmacy.gps_szerokosc + ', ' + pharmacy.gps_dlugosc }}</td>
      </tr>
      </tbody>
    </table>

    <nav aria-label="...">
      <ul class="pagination">
        <li :class="[activePage === 1 ? 'disabled' : '', 'page-item']">
          <a @click="getResults(activePage-1)" class="page-link">Poprzedni</a>
        </li>

        <li :class="[{active: activePage === name+1}, 'page-item']" v-for="(value, name, index) in links"><a @click="getResults(name+1)" class="page-link">{{ name + 1 }}</a></li>

        <li :class="[activePage === links.length ? 'disabled' : '', 'page-item']">
          <a @click="getResults(activePage+1)" class="page-link">Następny</a>
        </li>
      </ul>
    </nav>
  </div>
</template>

<script>
export default {
  data() {
    return {
      pharmacies: [],
      links: [],
      activePage: 1,
      disabled: false
    }
  },

  created() {
    axios
        .get('/api/pharmacies')
        .then(response => {
          this.pharmacies = response.data.data
          this.links = response.data.links

          console.log(response.data)

        })
        .catch(error => {
          console.log(error)
          this.errored = true
        })

    // this.getResults()
  },

  methods: {
    getResults(page) {
      console.log(page)
      this.activePage = page
      axios
          .get("/api/pharmacies?page=" + page)
          .then(response => {
            console.log(response)

            this.pharmacies = response.data.data;
            console.log(response.data);
          });
    }
  }
}
</script>
