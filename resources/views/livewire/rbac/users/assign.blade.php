@push('scripts')
<script type="module">
    window.addEventListener('notyf:ok', (e) => {
        const notyf = new Notyf();
        notyf.success(e.detail.message);
    });

    window.addEventListener('notyf:error', (e) => {
        const notyf = new Notyf();
        notyf.error(e.detail.message);
    });

    // new TomSelect('#roles', {});
</script>
@endpush
<div>
    <div class="mb-3">
        <h1 class="h3 d-inline align-middle">RBAC Users</h1>
        <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('rbac.users.index') }}">RBAC Users</a></li>
                <li class="breadcrumb-item active" aria-current="page">Assign</li>
            </ol>
        </nav>
    </div>
    <div class="card">
        <div class="card-body">
            @error('errorMessage') <span class="text-danger">{{ $message }}</span> @enderror
            <form wire:submit.prevent="submit">
                <div class="mb-4">
                    <label for="identifier" class="form-label">NIP/NIM</label>
                    <input id="identifier" type="text" class="form-control" placeholder="NIP/NIM" wire:model.defer="identifier" readonly>
                </div>
                <div class="mb-4">
                    <label for="name" class="form-label">Nama</label>
                    <input id="name" type="text" class="form-control" placeholder="Nama" wire:model.defer="name" readonly>
                </div>
                <div class="mb-4">
                    <label for="username" class="form-label">Username</label>
                    <input id="username" type="text" class="form-control" placeholder="Group" wire:model.defer="username" readonly>
                </div>
                <div class="mb-4">
                    <label for="roles" class="form-label">Peran</label>
                    <div wire:ignore>
                        <select id="roles" class="form-select" multiple wire:model="selectedRoles">
                            <option value="">Peran</option>
                            @foreach ($roles as $role)
                                <option value="{{ $role['name'] }}">{{ $role['name'] }}</option>
                            @endforeach
                        </select>
                    </div>
                    @error('roles') <span class="text-danger">{{ $message }}</span> @enderror
                </div>
                <div class="mb-4">
                    <button type="submit" class="btn btn-primary">Simpan</button>
                    <button type="button" wire:click="clearForm" class="btn btn-secondary">Batal</button>
                </div>
            </form>
        </div>
    </div>
</div>