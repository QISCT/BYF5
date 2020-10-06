<div>
  <form id="update-form" wire:submit.prevent="save">
    <div class="form-label-group">
      <input type="text" id="name" wire:model="name" class="form-control @error('name') is-invalid @enderror" placeholder="Page Name" autofocus>
      <label for="name">Page Name</label>
      @error('name') <div class="invalid-feedback"><span>{{ $message }}</span></div> @enderror
    </div>
    <div class="form-label-group">
      <input type="text" id="slug" wire:model="slug" class="form-control @error('slug') is-invalid @enderror" placeholder="Page Slug">
      <label for="slug">Page Slug</label>
      @error('slug') <div class="invalid-feedback"><span>{{ $message }}</span></div> @enderror
    </div>
  </form>
</div>
