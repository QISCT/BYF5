<x-app-layout>
  <x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
      Edit Site
    </h2>
  </x-slot>
  
  <div>
    <div class="max-w-7xl mx-auto py-10 sm:px-6 lg:px-8">
      <livewire:site.update-site-information-form :site="$site" />
  
      <x-jet-section-border />
  
      <livewire:site.update-domains-form :site="$site" />
      
      <x-jet-section-border />
  
      <livewire:site.update-contacts-form :site="$site" />
    </div>
  </div>
  
  
{{--  <div class="container mx-auto">--}}
{{--    <div class="bg-white m-8 p-8 overflow-hidden shadow-xl sm:rounded-lg">--}}
{{--      <livewire:site.site-update :site="$site" />--}}
{{--      <div class="flex justify-between mt-8">--}}
{{--        <a class="btn btn-gray" href="{{ url()->previous() }}">--}}
{{--          Cancel--}}
{{--        </a>--}}
{{--        <button type="submit" form="update-form" class="btn btn-blue">--}}
{{--          Update Site--}}
{{--        </button>--}}
{{--      </div>--}}
{{--    </div>--}}
{{--  </div>--}}
</x-app-layout>
