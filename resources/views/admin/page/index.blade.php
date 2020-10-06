<x-app-layout>
  <x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
      Page List
    </h2>
  </x-slot>
  
  <div class="container mx-auto">
    <div class="bg-white m-8 p-8 overflow-hidden shadow-xl sm:rounded-lg">
      <div class="mb-8">
        <a class="btn btn-purple" href="{{ route('sites.pages.create') }}">
          Create Page
        </a>
      </div>
      <livewire:page.page-browse />
    </div>
  </div>
</x-app-layout>
