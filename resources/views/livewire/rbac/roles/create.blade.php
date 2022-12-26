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
        <h1 class="h3 d-inline align-middle">RBAC Roles</h1>
        <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('rbac.roles.index') }}">RBAC Roles</a></li>
                <li class="breadcrumb-item active" aria-current="page">Create</li>
            </ol>
        </nav>
    </div>
    <div class="card">
        <div class="card-body">
            @error('errorMessage') <span class="text-danger">{{ $message }}</span> @enderror
            <form wire:submit.prevent="submit">
                <div class="mb-4">
                    <label for="text" class="form-label">Name</label>
                    <input id="text" type="text" class="form-control @error('role.name') border-danger @enderror" placeholder="Name" wire:model="role.name">
                    @error('role.name') <span class="text-danger">{{ $message }}</span> @enderror
                </div>
                <div class="mb-4">
                    @foreach ($group_permissions as $key => $permissions)
                    <div class="my-3">
                        <div class="form-check">
                            <input id="{{ $key }}" class="form-check-input" type="checkbox" value="{{ $key }}" wire:model="selectedGroupPermissions.{{ $key }}">
                            <label for="{{ $key }}" class="form-check-label fw-bold">{{ $key }}</label>
                        </div>
                    </div>
                    <div class="d-flex flex-wrap gap-2">
                        @foreach ($permissions as $perm)
                        <div class="form-check">
                            <input id="{{ $perm['id'] }}-{{ $perm['name'] }}" class="form-check-input" type="checkbox" wire:model="permissions" value="{{ $perm['id'] }}">
                            <label for="{{ $perm['id'] }}-{{ $perm['name'] }}" class="form-check-label">{{ $perm['name'] }}</label>
                        </div>
                        @endforeach
                    </div>
                    @endforeach
                </div>
                <div class="mb-4">
                    <button type="submit" class="btn btn-primary">Simpan</button>
                    <button type="button" wire:click="clearForm" class="btn btn-secondary">Batal</button>
                </div>
            </form>
        </div>
    </div>
</div>