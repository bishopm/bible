@extends('bible::layouts.master')

@section('title','Home page')

@section('content')
<div id="app" class="container">
  <form>
    <div class="form-row">
      <div class="col">
        <select @change="getverses" v-model="sversion" class="form-control form-control-sm">
          <option v-for="version in versions" :value="version.id">@{{version.abbr}}</option>
        </select>
      </div>
      <div class="col">
        <select @change="getverses" v-model="sbook" class="form-control form-control-sm">
          <option v-for="book in books" :value="book.id">@{{book.name}}</option>
        </select>
      </div>
      <div class="col">
        <select @change="getverses" v-model="schapter" class="form-control form-control-sm">
          <option v-for="c in totchapters">@{{c}}</option>
        </select>
      </div>
    </div>
  </form>
  <div class="row">
    <div class="col-12">
      <span v-for="verse in verses">
        <sup>@{{verse.verse}}</sup>@{{verse.text}} 
      </span>
    </div>
  </div>
</div>
@endsection

@section('js')
<script src="https://cdn.jsdelivr.net/npm/vue/dist/vue.js"></script>
<script src="https://unpkg.com/axios/dist/axios.min.js"></script>
<script>
var app = new Vue({
  el: '#app',
  data: {
    sversion: 1,
    sbook: 1,
    schapter: 1,
    verses: [],
    versions: [],
    books: [],
    chapters: [],
    totchapters: 50
  },
  mounted () {
    this.getdropdowns()
    this.getverses()
  },
  methods: {
    getdropdowns () {
      axios.get('http://localhost/bible/public/api/dropdowns')
        .then((response) => {
          this.versions=response.data.versions
          this.books=response.data.books
        })
        .catch(function (error) {
          console.log(error)
        })
    },
    getverses () {
      axios.get('http://localhost/bible/public/api/' + this.sversion + '/' + this.sbook + '/' + this.schapter)
        .then((response) => {
          this.verses = response.data
          this.totchapters = this.books[this.sbook-1].chapters
          if (this.totchapters < this.schapter) {
            this.schapter = 1
            this.getverses()
          }
        })
        .catch(function (error) {
          console.log(error)
        })
    }
  },
})
</script>
@endsection