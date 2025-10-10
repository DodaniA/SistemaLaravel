<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Materia;
use App\Models\User;

class MateriasTable extends Component
{
    /** @var \Illuminate\Support\Collection */
    public $materias = [];
    public $profesores = [];

    /** Campos de creación */
    public $creating = false;
    public $create = [
        'nombre' => '',
        'id_profesor' => null,
    ];

    /** Campos de edición */
    public $editId = null;
    public $form = [
        'nombre' => '',
        'id_profesor' => null,
    ];

    // ---------------------------------------------------------------------
    // Ciclo de vida
    // ---------------------------------------------------------------------
    public function mount()
    {
        $this->loadProfesores();
        $this->loadMaterias();
    }

    // ---------------------------------------------------------------------
    // Cargar datos
    // ---------------------------------------------------------------------
    public function loadProfesores()
    {
        // Solo usuarios con rol 'Profesor'
        $this->profesores = User::where('rol', 'Profesor')
            ->orderBy('name')
            ->get(['id', 'name']);
    }

    public function loadMaterias()
    {
        // Cargar materias con relación profesor
        $this->materias = Materia::with('profesor:id,name')
            ->orderBy('id', 'desc')
            ->get(['id', 'nombre', 'id_profesor']);
    }

    // ---------------------------------------------------------------------
    // Crear
    // ---------------------------------------------------------------------
    protected function createRules(): array
    {
        return [
            'create.nombre'      => ['required', 'string', 'max:255'],
            'create.id_profesor' => ['required', 'exists:users,id'],
        ];
    }

    public function openCreate()
    {
        $this->creating = true;
        $this->create = ['nombre' => '', 'id_profesor' => null];
    }

    public function cancelCreate()
    {
        $this->creating = false;
        $this->create = ['nombre' => '', 'id_profesor' => null];
    }

    public function store()
    {
        $this->validate($this->createRules());

        $data = $this->create;
        $data['id_profesor'] = (int) $data['id_profesor'];

        Materia::create($data);

        $this->cancelCreate();
        $this->loadMaterias();
        session()->flash('success', 'Materia creada correctamente.');
    }

    // ---------------------------------------------------------------------
    // Editar / actualizar
    // ---------------------------------------------------------------------
    protected function updateRules(): array
    {
        return [
            'form.nombre'      => ['required', 'string', 'max:255'],
            'form.id_profesor' => ['required', 'exists:users,id'],
        ];
    }

    public function edit($id)
    {
        $m = Materia::findOrFail($id);
        $this->editId = $m->id;
        $this->form = [
            'nombre'      => $m->nombre,
            'id_profesor' => $m->id_profesor,
        ];
    }

    public function update()
    {
        $this->validate($this->updateRules());

        $m = Materia::findOrFail($this->editId);
        $m->update($this->form);

        $this->resetEdit();
        $this->loadMaterias();
        session()->flash('success', 'Materia actualizada correctamente.');
    }

    public function cancel()
    {
        $this->resetEdit();
    }

    protected function resetEdit()
    {
        $this->editId = null;
        $this->form = ['nombre' => '', 'id_profesor' => null];
    }

    // ---------------------------------------------------------------------
    // Eliminar
    // ---------------------------------------------------------------------
    public function delete($id)
    {
        Materia::findOrFail($id)->delete();
        $this->loadMaterias();
        session()->flash('success', 'Materia eliminada correctamente.');
    }

    // ---------------------------------------------------------------------
    // Atributos personalizados para validaciones
    // ---------------------------------------------------------------------
    protected $validationAttributes = [
        'create.nombre' => 'nombre de la materia',
        'create.id_profesor' => 'profesor',
        'form.nombre' => 'nombre de la materia',
        'form.id_profesor' => 'profesor',
    ];

    // ---------------------------------------------------------------------
    // Renderizado
    // ---------------------------------------------------------------------
    public function render()
    {
        return view('livewire.materias-table');
    }
}
