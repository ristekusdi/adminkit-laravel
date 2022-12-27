@push('scripts')
<script type="module">
    window.addEventListener('swal:confirm', (e) => {
        swal({
            title: e.detail.title,
            text: e.detail.message,
            icon: 'warning',
            buttons: true,
            dangerMode: true,
        })
        .then((willDelete) => {
            if (willDelete) {
                window.livewire.emit('delete', e.detail.id, e.detail.name);
            }
        });
    });

    window.addEventListener('swal:ok', (e) => {
        swal({
            title: e.detail.title,
            text: e.detail.message,
            icon: 'success',
        })
        .then(() => window.livewire.emit('refreshTable'));
    });

    window.addEventListener('swal:error', (e) => {
        swal({
            title: e.detail.title,
            text: e.detail.message,
            icon: 'error',
        });
    });

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
                <li class="breadcrumb-item active" aria-current="page">Index</li>
            </ol>
        </nav>
        <div class="d-flex justify-content-end mb-4">
            <a href="{{ route('rbac.permissions.create') }}" class="btn btn-primary">Buat permissions</a>
        </div>
    </div>
    <div class="card">
        <div class="card-body">
            <div class="d-flex flex-column flex-md-row gap-2">
                <div class="mb-4">
                    <select class="form-select" wire:model="perPage">
                        <option value="10">10</option>
                        <option value="15">15</option>
                        <option value="25">25</option>
                    </select>
                </div>
                <div class="mb-4">
                    <input id="text" type="text" class="form-control" placeholder="Cari permission" wire:model.lazy="search">
                </div>
                <div class="mb-4">
                    <button type="submit" class="btn btn-primary" wire:click="refreshTable">Perbaharui data</button>
                </div>
            </div>
            <div wire:loading.flex wire:target="refreshTable, search, perPage" class="justify-content-center">
                <p>Memuat ulang data permissions</p>
            </div>
            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col">Nama</th>
                            <th scope="col">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($permissions as $perm)
                        <tr>
                            <td>{{ $perm->name }}</td>
                            <td>
                                <div class="d-flex gap-2 flex-column flex-md-row">
                                    <a href="{{ route('rbac.permissions.edit', $perm) }}" class="btn btn-primary">Edit</a>
                                    <button class="btn btn-danger" wire:click="deleteConfirm('{{ $perm->id }}', '{{ $perm->name }}')">
                                        Hapus
                                    </button>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="d-flex justify-content-end">
                {{ $permissions->links() }}
            </div>
        </div>
    </div>
</div>