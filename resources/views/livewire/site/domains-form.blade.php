<x-form-section>
  <x-slot name="title">
    Domains
  </x-slot>
  
  <x-slot name="description">
    Lorem ipsum dolor sit amet, consectetur adipiscing elit. Phasellus nec tellus porta lectus vulputate suscipit. In malesuada rutrum vehicula. Vivamus egestas id orci in condimentum. Cras laoreet nisi sit amet blandit porttitor. Mauris dignissim sapien ac nibh rutrum, sed consequat purus accumsan. Sed non lorem vitae massa ullamcorper consectetur.
  </x-slot>
  
  <x-slot name="form">
    <form id="update-form" wire:submit.prevent="save">
      <div class="col-span-6 sm:col-span-4">
        <table class="table-fixed w-full">
          <thead>
          <tr>
            <th class="w-1/2 px-4 py-2"></th>
            <th class="w-1/2 px-4 py-2"></th>
          </tr>
          </thead>
          <tbody>
          @foreach($domains as $i => $domain)
            <tr>
              <td>
                <div class="form-label-group m-0">
                  <input type="text" onkeydown="if(event.key == 'Backspace' && event.shiftKey)removeContactRow(event, {{$i}})" wire:model="domains.{{ $i }}.name" class="form-control form-inline @error('domains') is-invalid @enderror" placeholder="Domain Name">
                  <label>Domain Name</label>
                </div>
              </td>
              <td>
                <div class="form-label-group m-0">
                  <input type="text" wire:model="domains.{{ $i }}.cat" class="form-control form-inline @error('domains') is-invalid @enderror" placeholder="Domain Type">
                  <label>Domain Type</label>
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

@push('scripts')
  <script>
    window.workQue = [];
    function runQue(el, component) {
      let work = window.workQue.pop();
      if(work)
        setTimeout(work, 10);
    }
    document.addEventListener("livewire:load", () => {
      Livewire.hook('element.updated', runQue);
    });
    
    
    function addContactRow(e) {
      e.preventDefault();
      
      Livewire.emit('addContactRow');
      window.workQue.push(() => nextTabStop(e.target));
    }
    function removeContactRow(e, i) {
      e.preventDefault();
      if(i == 0)
        return;
      
      Livewire.emit('removeContactRow', i);
      prevTabStop(e.target);
    }
    
    
    const tabList = () =>  Array.prototype.filter.call(document.querySelectorAll('input, button, select, textarea, a[href]'), function(item) {return item.tabIndex >= "0"})
    function nextTabStop(el) {
      var list = tabList();
      var index = list.indexOf(el);
      let stop = list[index + 1] || list[0];
      stop.focus();
    }
    function prevTabStop(el) {
      var list = tabList();
      var index = list.indexOf(el);
      let stop = list[index - 1] || list[0];
      stop.focus();
    }
  </script>
@endpush
