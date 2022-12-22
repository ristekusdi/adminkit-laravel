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
        <h1 class="h3 d-inline align-middle">RBAC Users</h1>
        <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('rbac.users.index') }}">RBAC Users</a></li>
                <li class="breadcrumb-item active" aria-current="page">Index</li>
            </ol>
        </nav>
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
                    <select class="form-select" wire:model="q">
                        <option value="0">Tipe Pengguna</option>
                        <option value="unud_user_type_id:1">Mahasiswa</option>
                        <option value="unud_user_type_id:2">Dosen</option>
                        <option value="unud_user_type_id:3">Pegawai</option>
                    </select>
                </div>
                <div class="mb-4">
                    <input id="text" type="text" class="form-control" placeholder="Cari pengguna" wire:model.lazy="search">
                </div>
                <div class="mb-4">
                    <button type="submit" class="btn btn-primary" wire:click="refreshUsersTable">Perbaharui data</button>
                </div>
            </div>
            <div wire:loading.flex wire:target="refreshUsersTable, q, search, perPage" class="justify-content-center">
                <p>Memuat ulang data pengguna</p>
            </div>
            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col">NIP/NIM</th>
                            <th scope="col">Nama</th>
                            <th scope="col">Username</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($users as $user)
                        <tr>
                            <td>{{ $user['firstName'] }}</td>
                            <td>{{ $user['lastName'] }}</td>
                            <td>{{ $user['username'] }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="d-flex justify-content-end">
                @include('includes._simple_pagination', ['items' => $users->toArray()])
            </div>
        </div>
    </div>
</div>