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
      'alignment' => ['required', 'string', 'max:1000'],
      'bibliographies' => ['required', 'json'],
      'evaluationMechanisms' => ['required', 'json'],
      'learningEnvironments' => ['required', 'json'],
      'objective' => ['required', 'string', 'max:1000'],
      'practiceHours' => ['required', 'integer'],
      'teachingStrategies' => ['required', 'json'],
      'techniquesRequisites' => ['required', 'json'],
      'theoryHours' => ['required', 'json'],
    ];
  }

  public function attributes()
  {
    return [
      'area.id' => 'Id del Area',
      'speciality.id' => 'Id de la especialidad',
      'alignment' => 'Alineaciones',
      'bibliographies' => 'Bibliografias',
      'evaluationMechanisms' => 'Mecanismos de evaluación',
      'learningEnvironments' => 'Entornos de aprendizaje',
      'objective' => 'Objetivo',
      'practiceHours' => 'Horas prácticas',
      'teachingStrategies' => 'Estrategias de enseñanza',
      'techniquesRequisites' => 'Requistos ténicos',
      'theoryHours' => 'Horas teóricas'
    ];
  }
}
