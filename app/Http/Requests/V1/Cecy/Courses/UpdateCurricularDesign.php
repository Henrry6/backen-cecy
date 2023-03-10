<?php

namespace App\Http\Requests\V1\Cecy\Courses;

use Illuminate\Foundation\Http\FormRequest;

class UpdateCurricularDesign extends FormRequest
{
  public function authorize()
  {
    return true;
  }
  public function rules()
  {
    return [
      'area.id' => ['required', 'integer'],
      'speciality.id' => ['required', 'integer'],
      'objective' => ['required', 'string', 'max:1000'],
      'practiceHours' => ['required', 'integer'],
      'theoryHours' => ['required'],
    ];
  }

  public function attributes()
  {
    return [
      'area.id' => 'Id del Área',
      'speciality.id' => 'Id de la especialidad',
      'alignment' => 'Alineaciones',
      'bibliographies' => 'Bibliografías',
      'evaluationMechanisms' => 'Mecanismos de evaluación',
      'learningEnvironments' => 'Entornos de aprendizaje',
      'objective' => 'Objetivo',
      'practiceHours' => 'Horas prácticas',
      'teachingStrategies' => 'Estrategias de enseñanza',
      'techniquesRequisites' => 'Requisitos técnicos',
      'theoryHours' => 'Horas teóricas'
    ];
  }
}
