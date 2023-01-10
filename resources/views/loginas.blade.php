@push('styles')
<link href="https://cdn.jsdelivr.net/npm/tom-select@2.2.2/dist/css/tom-select.bootstrap5.min.css" rel="stylesheet">
@endpush
@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/tom-select@2.2.2/dist/js/tom-select.complete.min.js"></script>
<script>
    new TomSelect('#username', {
        valueField: 'username',
        labelField: 'username',
        searchField: ['username', 'lastName'],
        load: function(query, callback) {
            var url = '/api/rbac-users?search=' + encodeURIComponent(query);
            fetch(url)
                .then(response => response.json())
                .then(json => {
                    callback(json.users);
                })
                .catch(() => {
                    callback();
                });
        },
        // custom rendering functions for options and items
        render: {
            option: function(item, escape) {
                return `<div>${ escape(item.username) } ${ escape(item.lastName) }</div>`;
            },
            item: function(item, escape) {
                return `<div>${ escape(item.username) }</div>`;
            }
        }
    });
</script>
<script type="module">
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

<x-plain-layout>
    <div class="container d-flex flex-column">
        <div class="row vh-100">
            <div class="col-sm-10 col-md-8 col-lg-6 mx-auto d-table h-100">
                <div class="d-table-cell align-middle">

                    <div class="text-center mt-4">
                        <h1 class="h2">Login As</h1>
                        <p class="lead">
                            Login as with great responsibility.
                        </p>
                    </div>

                    @if (session('error'))
                    <div class="alert alert-danger" role="alert">
                        <p>{{ session('error') }}</p>
                    </div>
                    @endif

                    <div class="card">
                        <div class="card-body">
                            <div class="m-sm-4">
                                <form method="POST" action="{{ route('loginas.submit') }}">
                                    @csrf
                                    <div class="mb-3">
                                        <label for="username" class="form-label">Username</label>
                                        <select id="username" class="form-select" name="username" placeholder="Masukkan nama atau username">
                                        </select>
                                    </div>
                                    <div class="d-grid gap-3">
                                        <button type="submit" class="btn btn-lg btn-primary">Login as</button>
                                        <a href="{{ url('/') }}" class="btn btn-lg btn-secondary">Kembali ke Website</a>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</x-plain-layout>