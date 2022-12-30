@push('styles')
<link href="https://cdn.jsdelivr.net/npm/tom-select@2.2.2/dist/css/tom-select.bootstrap5.min.css" rel="stylesheet">
@endpush
@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/tom-select@2.2.2/dist/js/tom-select.complete.min.js"></script>
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
                    <div wire:ignore>
                        <label for="selectedRoles" class="form-label">Peran</label>
                        <select x-data="{
                                tomSelectInstance: null,
                                options: {{ collect($client_roles) }},
                                items: $wire.entangle('selectedRoles')
                            }" x-init="tomSelectInstance = new TomSelect($refs.input, {
                                valueField: 'name',
                                labelField: 'name',
                                searchField: 'name',
                                options: options,
                                items: items
                            }); $watch('items', (value, oldValue) => {
                                const result = JSON.parse(JSON.stringify(value));
                                if (result.length === 0) {
                                    tomSelectInstance.clear();
                                }
                            });" x-ref="input" x-cloak id="selectedRoles" class="form-select" multiple wire:model="selectedRoles" placeholder="Masukkan peran" autocomplete="off">
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