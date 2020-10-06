<x-app-layout>
  <x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
      View Page
    </h2>
  </x-slot>
  <div class="container mx-auto">
    <div class="bg-white m-8 p-8 overflow-hidden shadow-xl sm:rounded-lg">
      <div class="flex justify-between mb-4">
        <a class="btn btn-gray" href="{{ route('sites.show', $page->site) }}">
          {{ $page->site->name }}
        </a>
        <a class="btn btn-yellow" href="{{ route('sites.pages.edit', [$page->site, $page]) }}">
          Edit
        </a>
      </div>
      <div class="mb-3">
        <label>Name</label>
        <div>{{ $page->name }}</div>
      </div>
      <div class="mb-3">
        <label>Slug</label>
        <div>{{ $page->slug }}</div>
      </div>
    </div>
  </div>
</x-app-layout>
