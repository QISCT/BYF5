<x-form-section>
  <x-slot name="title">
    Contacts
  </x-slot>
  
  <x-slot name="description">
    lorem ipsum dolor sit amet, consectetur adipiscing elit. Phasellus nec tellus porta lectus vulputate suscipit. In malesuada rutrum vehicula. Vivamus egestas id orci in condimentum. Cras laoreet nisi sit amet blandit porttitor. Mauris dignissim sapien ac nibh rutrum, sed consequat purus accumsan. Sed non lorem vitae massa ullamcorper consectetur.
  </x-slot>
  
  <x-slot name="form">
    <form id="update-form" wire:submit.prevent="save">
      <div class="col-span-6 sm:col-span-4">
        <table class="table-fixed w-full">
          <thead>
          <tr>
            <th class="w-1/3 px-4 py-2"></th>
            <th class="w-1/3 px-4 py-2"></th>
            <th class="w-1/3 px-4 py-2"></th>
          </tr>
          </thead>
          <tbody>
          @foreach($contacts as $i => $contact)
            <tr>
              <td>
                <div class="form-label-group m-0">
                  <input type="text" onkeydown="if(event.key == 'Backspace' && event.shiftKey)removeContactRow(event, {{$i}})" wire:model="contacts.{{ $i }}.name" class="form-control form-inline @error('name') is-invalid @enderror" placeholder="Contact Name">
                  <label>Contact Name</label>
                </div>
              </td>
              <td>
                <div class="form-label-group m-0">
                  <input type="text" wire:model="contacts.{{ $i }}.phone" class="form-control form-inline @error('name') is-invalid @enderror" placeholder="Contact Phone">
                  <label>Contact Phone</label>
                </div>
              </td>
              <td>
                <div class="form-label-group m-0">
                  <input type="text" onkeydown="if(event.key == 'Enter' && event.shiftKey)addContactRow(event)" wire:model="contacts.{{ $i }}.email" class="form-control form-inline @error('name') is-invalid @enderror" placeholder="Contact Email">
                  <label>Contact Email</label>
                </div>
              </td>
            </tr>
          @endforeach
          </tbody>
        </table>
      </div>
    </form>
  </x-slot>
</x-form-section>
