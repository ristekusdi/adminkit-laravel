<?php

namespace App\Http\Livewire\RBAC\Roles;

use App\Models\Role;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;

    public $first = 0;
    public $perPage = 10;
    public $search = '';

    protected $listeners = ['refreshTable', 'delete', 'deleteOk', 'deleteError'];

    protected $paginationTheme = 'bootstrap';

    public function updatingSearch()
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
        return view('livewire.rbac.roles.index', [
            'roles' => Role::where('name', 'like', '%'.$this->search.'%')
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
        $role = Role::where('id', '=', $id)->delete();
        if ($role) {
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
            'message' => "Peran {$data['name']} berhasil dihapus!"
        ]);
    }

    public function deleteError($data)
    {
        $this->dispatchBrowserEvent('swal:error', [
            'title' => 'Gagal!',
            'message' => "Peran {$data['name']} gagal dihapus!"
        ]);
    }
}
