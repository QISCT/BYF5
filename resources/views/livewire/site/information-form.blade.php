<x-form-section submit="save">
  <x-slot name="title">
    Site Information
  </x-slot>
  
  <x-slot name="description">
    Lorem ipsum dolor sit amet, consectetur adipiscing elit. Phasellus nec tellus porta lectus vulputate suscipit. In malesuada rutrum vehicula. Vivamus egestas id orci in condimentum. Cras laoreet nisi sit amet blandit porttitor. Mauris dignissim sapien ac nibh rutrum, sed consequat purus accumsan. Sed non lorem vitae massa ullamcorper consectetur.
  </x-slot>
  
  <x-slot name="form">
    <div class="col-span-6 sm:col-span-4">
      <div class="form-label-group">
        <input type="text" id="name" wire:model="name" class="form-control @error('name') is-invalid @enderror" placeholder="Site Name" autofocus>
        <label for="name">Site Name</label>
        @error('name') <div class="invalid-feedback"><span>{{ $message }}</span></div> @enderror
      </div>
      <div class="form-label-group">
        <select id="status" wire:model="status" class="form-control @error('status') is-invalid @enderror" data-chosen="{{ $status }}" onchange="this.dataset.chosen=this.value; ">
          <option value="">----</option>
          @foreach($status_options as $n => $text)
            <option value="{{ $n }}">{{ $n }} | {{ $text }}</option>
          @endforeach
        </select>
        <label for="status">Site Status</label>
        @error('status') <div class="invalid-feedback"><span>{{ $message }}</span></div> @enderror
      </div>
    </div>
  </x-slot>
  
  <x-slot name="actions">
    <x-jet-action-message class="mr-3" on="saved">
      Saved.
    </x-jet-action-message>
    
    <x-jet-button>
      Save
    </x-jet-button>
  </x-slot>
</x-form-section>
