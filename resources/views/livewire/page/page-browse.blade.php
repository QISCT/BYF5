<table class="table-auto w-full">
  <caption><span class="font-bold text-xl float-left">Pages</span></caption>
  <thead>
  <tr>
    <th class="px-8 py-4">Created At</th>
    <th class="px-8 py-4">Name</th>
    <th class=""></th>
  </tr>
  </thead>
  <tbody>
  @foreach($pages as $page)
    <tr>
      <td class="border px-8 py-4">{{ $page->created_at->format('Y-m-d') }}</td>
      <td class="border px-8 py-4">{{ $page->name }}</td>
      <td class="border p-4">
        <a href="{{ route('sites.pages.show', [$page->site, $page]) }}" class="btn btn-blue">
          View Page
        </a>
      </td>
    </tr>
  @endforeach
  </tbody>
  <tfoot>
  <tr>
    <td class="px-8 py-4" colspan="3">{!! $pages->links('livewire.paginator') !!}</td>
  </tr>
  </tfoot>
</table>
