<?php

namespace App\Livewire;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Livewire\Component;

class UsersTable extends Component
{
    /** Tabla */
    public $users = [];

    /** Creación (form arriba o donde lo pongas) */
    public $name = '';
    public $email = '';
    public $role = ' Paciente'; 
    public $password = '';
    public $password_confirmation = '';

    /** Edición inline */
    public $editId = null;
    public $form = [
        'name'  => '',
        'email' => '',
        'role'   => '',
    ];

    public function mount()
    {
        $this->loadUsers();
    }

    public function loadUsers()
    {
        $this->users = User::select('id','name','email','role')
            ->orderBy('id','desc')
            ->get();
    }

    /** ---------- CREACIÓN ---------- */
    protected function creationRules(): array
    {
        return [
            'name'                  => ['required','string','max:255'],
            'email'                 => ['required','email','max:255','unique:users,email'],
            'role'                   => ['required','in:Cordinador,Profesor,Alumno'], // unifica ortografía con tu BD
            'password'              => ['required','string','min:8','confirmed'],
        ];
    }

    public function register()
    {
        $this->validate($this->creationRules());

        User::create([
            'name'     => $this->name,
            'email'    => $this->email,
            'role'      => $this->rol,
            'password' => Hash::make($this->password),
        ]);

        // Limpia el formulario de creación
        $this->reset(['name','email','rol','password','password_confirmation']);

        // Recarga la tabla
        $this->loadUsers();

        session()->flash('success', 'Usuario creado.');
    }

    /** ---------- EDICIÓN ---------- */
    protected function updateRules(): array
    {
        return [
            'form.name'  => ['required','string','max:255'],
            'form.email' => [
                'required','email','max:255',
                Rule::unique('users','email')->ignore($this->editId),
            ],
            'form.role'   => ['required','in:Cordinador,Profesor,Alumno'],
        ];
    }

    public function edit($id)
    {
        $user = User::findOrFail($id);
        $this->editId = $user->id;
        $this->form = [
            'name'  => $user->name,
            'email' => $user->email,
            'role'   => $user->rol,
        ];
    }

    public function update()
    {
        $this->validate($this->updateRules());

        $user = User::findOrFail($this->editId);
        $user->update($this->form);

        $this->resetEdit();
        $this->loadUsers();
        session()->flash('success', 'Usuario actualizado.');
    }

    public function cancel()
    {
        $this->resetEdit();
    }

    protected function resetEdit()
    {
        $this->editId = null;
        $this->form = ['name'=>'','email'=>'','role'=>''];
    }

    /** ---------- RENDER ---------- */
    public function render()
    {
        return view('livewire.users-table');
    }
}
