<div>
  <form id="update-form" wire:submit.prevent="save">
    <div class="form-label-group">
      <input type="text" id="name" wire:model="name" class="form-control @error('name') is-invalid @enderror" placeholder="Firm Name" autofocus>
      <label for="name">Firm Name</label>
      @error('name') <div class="invalid-feedback"><span>{{ $message }}</span></div> @enderror
    </div>
    <div class="form-label-group">
      <select id="type" wire:model="type" class="form-control @error('type') is-invalid @enderror" data-chosen="{{ $type }}" onchange="this.dataset.chosen=this.value; ">
        <option value="">----</option>
        @foreach($options as $option)
          <option value="{{ $option }}">{{ $option }}</option>
        @endforeach
      </select>
      <label for="type">Firm Type</label>
      @error('type') <div class="invalid-feedback"><span>{{ $message }}</span></div> @enderror
    </div>
  </form>
</div>
