@push('styles')
<style>
    .nested-sort {
        padding: 0;
    }

    .nested-sort--enabled li {
        cursor: move;
    }

    .nested-sort li {
        list-style: none;
        padding: 10px;
        background: #fff;
    }

    .nested-sort li ol {
        padding: 0;
        margin-top: 10px;
        margin-bottom: -5px;
    }

    /* ns-dragged is the class name of the item which is being dragged */
    .nested-sort .ns-dragged {
        border: 1px solid red;
    }

    /* ns-targeted is the class name of the item on which the dragged item is hovering */
    .nested-sort .ns-targeted {
        border: 1px solid green;
    }
</style>
@endpush
@push('scripts')
<script type="module">
    const url_refresh_sortable_menu = document.querySelector('input[name="url_refresh_sortable_menu"]').value;
    const url_delete_menu = document.querySelector('input[name="url_delete_menu"]').value;
    const csrf_token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
    new NestedSort({
        el: '#draggable',
        actions: {
            onDrop(data) {
                fetch(url_refresh_sortable_menu, {
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrf_token
                    },
                    method: 'POST',
                    body: JSON.stringify({
                        items: data
                    })
                })
                .then(response => {
                    if (response.status === 204) {
                        const notyf = new Notyf();
                        notyf.success('Success sort menu');
                    } else {
                        const notyf = new Notyf();
                        notyf.error('Failed sort menu');
                    }
                })
                .catch(error => {
                    console.log(error)
                })
            }
        },
        nestingLevels: 2
    });

    document.querySelectorAll('button.delete-menu').forEach(el => {
        el.addEventListener('click', (e) => {
            swal({
                title: 'Peringatan!',
                text: `Anda yakin akan menghapus menu ${el.dataset.text}?`,
                icon: 'warning',
                buttons: true,
                dangerMode: true
            })
            .then((willDelete) => {
                if (willDelete) {
                    return fetch(url_delete_menu, {
                            headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': csrf_token
                        },
                        method: 'POST',
                        body: JSON.stringify({
                            id: el.dataset.id
                        })
                    });
                }
            })
            .then(results => {
                return results.json();
            })
            .then(json => {
                swal(`Menu ${el.dataset.text} berhasil dihapus`)
                .then(() => window.location.reload());
            });
        });
    })
</script>
@endpush

<x-app-layout>
    <h1 class="h3 mb-4">Menus</h1>
    <div class="d-flex justify-content-end mb-4">
        <a href="{{ route('menus.create') }}" class="btn btn-primary">Buat menu</a>
    </div>
    {!! load_sortable_menu() !!}
    <input type="hidden" name="url_refresh_sortable_menu" value="{{ route('menus.refresh') }}">
    <input type="hidden" name="url_delete_menu" value="{{ route('menus.delete') }}">
</x-app-layout>