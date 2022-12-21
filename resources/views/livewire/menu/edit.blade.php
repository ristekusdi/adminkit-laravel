@push('scripts')
<script>
    window.addEventListener('notyf:ok', (e) => {
        const notyf = new Notyf();
        notyf.success(e.detail.message);
    });

    window.addEventListener('notyf:error', (e) => {
        const notyf = new Notyf();
        notyf.error(e.detail.message);
    });
</script>
@endpush
<div>
    <div class="mb-3">
        <h1 class="h3 d-inline align-middle">Menus</h1>
        <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('menus.index') }}">Menus</a></li>
                <li class="breadcrumb-item active" aria-current="page">Create menu</li>
            </ol>
        </nav>
    </div>
    <div class="card">
        <div class="card-body">
            @error('errorMessage') <span class="text-danger">{{ $message }}</span> @enderror
            <form wire:submit.prevent="submit">
                <div class="mb-4">
                    <label for="text" class="form-label">Name</label>
                    <input id="text" type="text" class="form-control @error('text') border-danger @enderror" placeholder="Name" wire:model="text">
                    @error('text') <span class="text-danger">{{ $message }}</span> @enderror
                </div>
                <div class="mb-4">
                    <label for="path" class="form-label">Path</label>
                    <input id="path" type="text" class="form-control @error('path') border-danger @enderror" placeholder="Path" wire:model="path">
                    @error('path') <span class="text-danger">{{ $message }}</span> @enderror
                </div>
                <div class="mb-4">
                    <label for="parent" class="form-label">Parent</label>
                    <select id="parent" class="form-select" wire:model="parent">
                        <option value="0">Parent</option>
                        @foreach ($parents as $parent)
                            <option value="{{ $parent->id }}">{{ $parent->text }}</option>
                        @endforeach
                    </select>
                    @error('parent') <span class="error">{{ $message }}</span> @enderror
                </div>
                <div class="mb-4">
                    <label for="sub-parent" class="form-label">Sub Parent</label>
                    <select id="sub-parent" class="form-select" wire:model="sub_parent">
                        <option value="0">Sub Parent</option>
                        @if (!is_null($selectedParent))
                            @foreach ($sub_parents as $sub_parent)
                                <option value="id={{ $sub_parent['id'] }}&level={{ $sub_parent['level'] }}">
                                    {{ $sub_parent['text'] }}
                                </option>
                            @endforeach
                        @endif
                    </select>
                    @error('sub_parent') <span class="error">{{ $message }}</span> @enderror
                </div>
                <div class="mb-4">
                    <button type="submit" class="btn btn-primary">Simpan</button>
                    <button type="button" wire:click="clearForm" class="btn btn-secondary">Batal</button>
                </div>
            </form>
        </div>
    </div>
</div>
