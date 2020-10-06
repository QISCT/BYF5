<x-app-layout>
  <x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
      View Firm
    </h2>
  </x-slot>
  
  <div class="container mx-auto">
    <div class="bg-white m-8 p-8 overflow-hidden shadow-xl sm:rounded-lg">
      <div class="flex justify-between mb-4">
        <a class="btn btn-gray" href="{{ route('firms.index') }}">
          List
        </a>
        <a class="btn btn-yellow" href="{{ route('firms.edit', $firm) }}">
          Edit
        </a>
      </div>
      <div class="form-group">
        <label>Name</label>
        <div>{{ $firm->name }}</div>
      </div>
      <div class="form-group">
        <label>Type</label>
        <div>{{ $firm->type }}</div>
      </div>
      <div class="p-5">
        <livewire:site.site-browse class="mb-3" :scope="[$firm, 'sites']"/>
        <a class="btn btn-purple" href="{{ route('firms.sites.create', $firm) }}">
          Create Site
        </a>
      </div>
    </div>
  </div>
</x-app-layout>
