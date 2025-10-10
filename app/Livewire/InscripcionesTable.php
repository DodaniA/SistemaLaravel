<?php

namespace App\Livewire;

use App\Models\User;
use App\Models\Materia;
use App\Models\Inscripcion;
use Illuminate\Validation\Rule;
use Livewire\Component;

class InscripcionesTable extends Component
{
    /** Listado principal */
    public $inscripciones = [];

    /** Catálogos para selects */
    public $alumnos = [];
    public $materias = [];

    /** Creación inline */
    public $creating = false;
    public $create = [
        'id_alumno'  => null,
        'id_materia' => null,
    ];

    /** Edición inline */
    public $editId = null;
    public $form = [
        'id_alumno'  => null,
        'id_materia' => null,
    ];

    public function mount()
    {
        $this->loadCatalogos();
        $this->loadInscripciones();
    }

    public function loadCatalogos()
    {
        // Solo alumnos con rol 'Alumno'
        $this->alumnos = User::where('rol', 'Alumno')
            ->orderBy('name')
            ->get(['id','name']);

        // Todas las materias
        $this->materias = Materia::orderBy('nombre')
            ->get(['id','nombre']);
    }

    public function loadInscripciones()
    {
        // Trae inscripción con relaciones para mostrar nombres
        $this->inscripciones = Inscripcion::with([
            'alumno:id,name',
            'materia:id,nombre',
        ])
        ->orderBy('id','desc')
        ->get(['id','id_alumno','id_materia']);
    }

    /** ----------- Crear ----------- */
    protected function createRules(): array
    {
        return [
            'create.id_alumno'  => [
                'required',
                Rule::exists('users', 'id')->where(fn($q) => $q->where('rol', 'Alumno')),
            ],
            'create.id_materia' => ['required','exists:materias,id'],
        ];
    }

    public function openCreate()
    {
        $this->creating = true;
        $this->create = ['id_alumno'=>null, 'id_materia'=>null];
    }

    public function cancelCreate()
    {
        $this->creating = false;
        $this->create = ['id_alumno'=>null, 'id_materia'=>null];
    }

    public function store()
    {
        $this->validate($this->createRules());

        Inscripcion::create($this->create);

        $this->cancelCreate();
        $this->loadInscripciones();
        session()->flash('success','Inscripción creada.');
    }

    /** ----------- Editar / Actualizar ----------- */
    protected function updateRules(): array
    {
        return [
            'form.id_alumno'  => [
                'required',
                Rule::exists('users', 'id')->where(fn($q) => $q->where('rol', 'Alumno')),
            ],
            'form.id_materia' => ['required','exists:materias,id'],
        ];
    }

    public function edit($id)
    {
        $i = Inscripcion::findOrFail($id);
        $this->editId = $i->id;
        $this->form = [
            'id_alumno'  => $i->id_alumno,
            'id_materia' => $i->id_materia,
        ];
    }

    public function update()
    {
        $this->validate($this->updateRules());

        $i = Inscripcion::findOrFail($this->editId);
        $i->update($this->form);

        $this->resetEdit();
        $this->loadInscripciones();
        session()->flash('success','Inscripción actualizada.');
    }

    public function cancel()
    {
        $this->resetEdit();
    }

    protected function resetEdit()
    {
        $this->editId = null;
        $this->form = ['id_alumno'=>null, 'id_materia'=>null];
    }

    /** ----------- Eliminar ----------- */
    public function delete($id)
    {
        Inscripcion::findOrFail($id)->delete();
        $this->loadInscripciones();
        session()->flash('success','Inscripción eliminada.');
    }

    public function render()
    {
        return view('livewire.inscripciones-table');
    }
}
