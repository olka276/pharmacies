<template>
  <div class="container">
    <div class="search-wrapper">
      <label>Szukaj:</label>

      <input type="text" v-model="nameSearch"  @input="filter('name', $event.target.value)"
             placeholder="Nazwa"/>
      <input type="text" @input="filter('post_code', $event.target.value)"
             placeholder="Kod pocztowy"/>
      <input type="text" @input="filter('city', $event.target.value)"
             placeholder="Miejscowość"/>
    </div>
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

    <nav v-if="this.pharmacies.length > 0" aria-label="...">
      <ul class="pagination">
        <li :class="[activePage === 1 ? 'disabled' : '', 'page-item']">
          <a @click="filter('name', nameSearch, activePage-1)" class="page-link">Poprzedni</a>
        </li>

        <li :class="[{active: activePage === name+1}, 'page-item']" v-for="(value, name, index) in links">
          <a @click="filter('name', nameSearch, name + 1)" class="page-link">{{ name + 1 }}</a>
        </li>

        <li :class="[activePage === links.length ? 'disabled' : '', 'page-item']">
          <a @click="filter('name', nameSearch, activePage + 1)" class="page-link">Następny</a>
        </li>
      </ul>
    </nav>
  </div>
</template>

<script>
export default {
  data() {
    return {
      nameSearch: "",
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
        })
        .catch(error => {
          this.errored = true
        })
  },
  methods: {
    filter(key, value, page) {
      console.log(key, value, page)
      this.activePage = page === undefined ? 1 : page
      const params = {
        page: this.activePage
      }
      params[key] = value
      axios
          .get("/api/pharmacies", {params})
          .then(response => {
            this.pharmacies = response.data.data;
            this.links = response.data.links
            this.links.pop();
            this.links.shift();
          });
    }
  }
}
</script>
