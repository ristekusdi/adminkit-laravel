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
        <h1 class="h3 d-inline align-middle">RBAC Permissions</h1>
        <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('rbac.permissions.index') }}">RBAC Permissions</a></li>
                <li class="breadcrumb-item active" aria-current="page">Edit</li>
            </ol>
        </nav>
    </div>
    <div class="card">
        <div class="card-body">
            @error('errorMessage') <span class="text-danger">{{ $message }}</span> @enderror
            <form wire:submit.prevent="submit">
                <div class="mb-4">
                    <label for="text" class="form-label">Name</label>
                    <input id="text" type="text" class="form-control @error('permission.name') border-danger @enderror" placeholder="Name" wire:model.defer="permission.name">
                    @error('permission.name') <span class="text-danger">{{ $message }}</span> @enderror
                </div>
                <div class="mb-4">
                    <label for="permission-menu-id" class="form-label">Menu</label>
                    <select id="permission-menu-id" class="form-select" wire:model="permission.menu_id">
                        <option value="0" selected>Menu</option>
                        @foreach ($menus as $menu)
                            <option value="{{ $menu->id }}">{{ $menu->text }}</option>
                        @endforeach
                    </select>
                    @error('permission.menu_id') <span class="text-danger">{{ $message }}</span> @enderror
                </div>
                <div class="mb-4">
                    <label for="text" class="form-label">Group</label>
                    <input id="text" type="text" class="form-control @error('permission.group') border-danger @enderror" placeholder="Group" wire:model.defer="permission.group">
                    @error('permission.group') <span class="text-danger">{{ $message }}</span> @enderror
                </div>
                <div class="mb-4">
                    <button type="submit" class="btn btn-primary">Simpan</button>
                    <button type="button" wire:click="clearForm" class="btn btn-secondary">Batal</button>
                </div>
            </form>
        </div>
    </div>
</div>