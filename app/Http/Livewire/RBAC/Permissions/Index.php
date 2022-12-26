<?php

namespace App\Http\Livewire\RBAC\Permissions;

use App\Models\Permission;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;

    public $first;
    public $perPage = 10;
    public $search;

    protected $listeners = ['refreshTable', 'delete', 'deleteOk', 'deleteError'];

    protected $paginationTheme = 'bootstrap';

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatingPerPage()
    {
        $this->resetPage();
    }

    public function refreshTable()
    {
        $this->first = 0;
        $this->perPage = 10;
        $this->search = '';
    }

    public function render()
    {
        return view('livewire.rbac.permissions.index', [
            'permissions' => Permission::where('name', 'like', '%'.$this->search.'%')
                ->paginate($this->perPage)
        ]);
    }

    public function deleteConfirm($id, $name)
    {
        $this->dispatchBrowserEvent('swal:confirm', [
            'title' => "Peringatan!",
            'message' => "Anda yakin akan menghapus peran {$name}?",
            'id' => $id,
            'name' => $name
        ]);
    }

    public function delete($id, $name)
    {
        $permission = Permission::where('id', '=', $id)->delete();
        if ($permission) {
            $this->emit('deleteOk', array(
                'name' => $name
            ));
        } else {
            $this->emit('deleteError', array(
                'name' => $name
            ));
        }
    }

    public function deleteOk($data)
    {
        $this->dispatchBrowserEvent('swal:ok', [
            'title' => 'Berhasil!',
            'message' => "Permission {$data['name']} berhasil dihapus!"
        ]);
    }

    public function deleteError($data)
    {
        $this->dispatchBrowserEvent('swal:error', [
            'title' => 'Gagal!',
            'message' => "Permission {$data['name']} gagal dihapus!"
        ]);
    }
}
