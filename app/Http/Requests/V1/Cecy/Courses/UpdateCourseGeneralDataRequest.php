<?php

namespace App\Http\Requests\V1\Cecy\Courses;

use Illuminate\Foundation\Http\FormRequest;

class UpdateCourseGeneralDataRequest extends FormRequest
{
  public function authorize()
  {
    return true;
  }
  public function rules()
  {
    return [

      'category.id' => ['required', 'integer'],
      'career.id' => ['required', 'integer'],
      'certifiedType.id' => ['required', 'integer'],
      'courseType.id' => ['required', 'integer'],
      'entityCertification.id' => ['required', 'integer'],
      'formationType.id' => ['required', 'integer'],
      'modality.id' => ['required', 'integer'],
      'abbreviation' => ['required', 'string', 'max:100'],
      'duration' => ['required', 'integer'],
      // 'needs' => ['required', 'json'],
      'project' => ['required', 'string', 'max:1000'],
      // 'participantTypes.id' => ['required', 'json'],
      // 'targetGroups' => ['required'],
      'summary' => ['required',  'string', 'max:1000'],
    ];
  }

  public function attributes()
  {
    return [

      'category.id' => 'Id de la categoria',
      'career.id' => 'Id de la carrera',
      'certifiedType.id' => 'Id del tipo de certitificado',
      'courseType.id' => 'Id del tipo de curso',
      'entityCertification.id' => 'Id de entidad que valida',
      'formationType.id' => 'Id del tipo de formacion',
      'modality.id' => 'Id  de la modalidad',
      'abbreviation' => 'Abreviación',
      'duration' => 'Duración',
      'needs' => 'Necesidades',
      'project' => 'Proyecto',
      'participantTypes.id' =>'Tipo de participantes de curso',
      // 'targetGroups' => 'Ids de grupos al que va dirigido el curso',
      'summary' => 'Sumario',
    ];
  }
}
