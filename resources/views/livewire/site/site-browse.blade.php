<table class="table-auto w-full">
  <caption><span class="font-bold text-xl float-left">Sites</span></caption>
  <thead>
  <tr>
    <th class="px-8 py-4">Created At</th>
    <th class="px-8 py-4">Name</th>
    <th class="px-8 py-4">Primary Domain</th>
    <th class="px-8 py-4">
    </th>
  </tr>
  </thead>
  <tbody>
  @foreach($sites as $site)
    <tr>
      <td class="border px-8 py-4">{{ $site->created_at->format('Y-m-d') }}</td>
      <td class="border px-8 py-4">{{ $site->name }}</td>
      <td class="border px-8 py-4">{{ $site->primary_domain }}</td>
      <td class="border p-4">
        <a href="{{ route('sites.show', $site) }}" class="btn btn-blue">
          View Site
        </a>
      </td>
    </tr>
  @endforeach
  </tbody>
  <tfoot>
  <tr>
    <td class="px-8 py-4" colspan="4">{!! $sites->links('livewire.paginator') !!}</td>
  </tr>
  </tfoot>
</table>
