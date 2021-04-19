<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Proyecto extends Model
{
    use HasFactory;

    protected $table = 'proyectos';

    protected $fillable = ['id', 'nombre', 'descripcion', 'fecha_creacion'];

    // Si no queremos usar los campos updated_at y created_at lo indicamos con:
    public $timestamps = false;

    // Relación muchos a muchos.
    public function users()
    {
        // En las relaciones muchos a muchos si no se indica solamente va a coger los campos que relacionan una tabla con la otra
        // por el nombre de la clase, ejemplo persona_id, etc..
        // Si queremos que devuelva más campos de la tabla pivot hay que indicarlo en el modelo también.
        return $this->belongsToMany(User::class)->withPivot('id','name', 'email');
    }
}
