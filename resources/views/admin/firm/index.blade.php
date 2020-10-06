<x-app-layout>
  <x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
      Firm List
    </h2>
  </x-slot>
  
  <div class="container mx-auto">
    <div class="bg-white m-8 p-8 overflow-hidden shadow-xl sm:rounded-lg">
      <div class="mb-8">
        <a class="btn btn-purple" href="{{ route('firms.create') }}">
          Create Firm
        </a>
      </div>
      <livewire:firm.firm-browse />
    </div>
  </div>
</x-app-layout>
