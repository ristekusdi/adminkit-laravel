<?php

namespace App\Http\Livewire\RBAC\Users;

use Livewire\Component;
use RistekUSDI\RBAC\Connector\Connector;

class Index extends Component
{
    public $first = 0;
    public $perPage = 10;
    public $q = 'unud_user_type_id:1 unud_user_type_id:2 unud_user_type_id:3';
    public $search;

    protected $listeners = ['refreshUsersTable'];

    public function previousPage()
    {
        $this->first = $this->first - $this->perPage;
    }

    public function nextPage()
    {
        $this->first = $this->first + $this->perPage;
    }

    public function updatingSearch()
    {
        $this->first = 0;
    }

    public function updatingQ()
    {
        $this->first = 0;
    }

    public function refreshUsersTable()
    {
        $this->first = 0;
        $this->perPage = 10;
        $this->search = '';
        $this->q = '';
    }

    public function render()
    {
        return view('livewire.rbac.users.index', [
            'users' => collect((new Connector)->getUsers(array(
                'first' => $this->first,
                'max' => $this->perPage,
                'search' => $this->search,
                // key "q" is optional
                'q' => $this->q
            )))
        ]);
    }
}
