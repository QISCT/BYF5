<x-app-layout>
  <x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
      View Site
    </h2>
  </x-slot>
  
  <div class="container mx-auto">
    <div class="bg-white m-8 p-8 overflow-hidden shadow-xl sm:rounded-lg">
      <div class="flex justify-between mb-4">
        <a class="btn btn-gray" href="{{ route('firms.show', $site->firm) }}">
          {{ $site->firm->name }}
        </a>
        <a class="btn btn-yellow" href="{{ route('sites.edit', $site) }}">
          Edit
        </a>
      </div>
      <div class="mb-3">
        <label>Name</label>
        <div>{{ $site->name }}</div>
      </div>
      <div class="mb-3">
        <label>Account</label>
        <div>{{ $site->account }}</div>
      </div>
      <div class="mb-3">
        <label>Status</label>
        <div>{{ $site->status }}</div>
      </div>
      <div class="mb-3">
        <table class="table-auto">
          <caption><span class="font-bold float-left">{{ Str::plural('Domain', $site->domains->count()) }}</span></caption>
          <tbody>
          @foreach($site->domains as $domain)
            {!! $domain !!}
          @endforeach
          </tbody>
        </table>
      </div>
      <div class="mb-3">
        <table class="table-auto">
          <caption><span class="font-bold float-left">{{ Str::plural('Contact', $site->contacts->count()) }}</span></caption>
          <tbody>
          @foreach($site->contacts as $contact)
            {!! $contact !!}
          @endforeach
          </tbody>
        </table>
      </div>
      <div class="mb-3">
        <livewire:page.page-browse class="mb-3" :scope="[$site, 'pages']"/>
        <a class="btn btn-purple" href="{{ route('sites.pages.create', $site) }}">
          Create Page
        </a>
      </div>
    </div>
  </div>
</x-app-layout>
