<table class="table-auto w-full">
  <thead>
  <tr>
    <th class="px-8 py-4">Created At</th>
    <th class="px-8 py-4">Name</th>
    <th class="px-8 py-4">Type</th>
    <th class="px-8 py-4">
    </th>
  </tr>
  </thead>
  <tbody>
  @foreach($firms as $firm)
    <tr>
      <td class="border px-8 py-4">{{ $firm->created_at->format('Y-m-d') }}</td>
      <td class="border px-8 py-4">{{ $firm->name }}</td>
      <td class="border px-8 py-4">{{ $firm->type }}</td>
      <td class="border p-4">
        <a href="{{ route('firms.show', $firm) }}" class="btn btn-blue">
          View Firm
        </a>
      </td>
    </tr>
  @endforeach
  </tbody>
</table>
