<x-bible::layouts.web pageName="Home">
  <style>
    .vno {
      vertical-align: text-top;
      font-weight: bold;
      position: relative;
      display: inline;
      line-height: normal;
      top: auto;
    }
  </style>
  <div class="row">
    <div class="col-md-8">
        @livewire('bible')
    </div>
    <div class="col-md-4">
      <h3 class="text-center">Notes</h3>
    </div>
  </div>
</x-bible::layouts.web>