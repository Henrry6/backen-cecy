<?php

namespace App\Http\Requests\V1\Cecy\Courses;

use Illuminate\Foundation\Http\FormRequest;

class StoreCourseRequest extends FormRequest
{
  public function authorize()
  {
    return true;
  }
  public function rules()
  {
    return [
      'academicPeriod.id' => ['required', 'integer'],
      'area.id' => ['required', 'integer'],
      'entityCertification.id' => ['required', 'integer'],
      'career.id' => ['required', 'integer'],
      'category.id' => ['required', 'integer'],
      'formationType.id' => ['required', 'integer'],
      'certifiedType.id' => ['required', 'integer'],
      'complianceIndicators.id' => ['required', 'integer'],
      'control.id' => ['required', 'integer'],
      'courseType.id' => ['required', 'integer'],
      'frequency.id' => ['required', 'integer'],
      'modality.id' => ['required', 'integer'],
      'meanVerification.id' => ['required', 'integer'],
      'responsible.id' => ['required', 'integer'],
      'speciality.id' => ['required', 'integer'],
      'state.id' => ['required', 'integer'],
      'abbreviation' => ['required', 'string', 'max:100'],
      'alignment' => ['required', 'string', 'max:1000'],
      'approvedAt' => ['required', 'date'],
      'bibliographies' => ['required', 'json'],
      'code' => ['required', 'max:100'],
      'cost' => ['required', 'double'],
      'duration' => ['required', 'integer'],
      'evaluationMechanisms' => ['required', 'json'],
      'expiredAt' => ['required', 'date'],
      'facilities' => ['required', 'json'],
      'free' => ['required', 'boolean'],
      'name' => ['required', 'string', 'max:200'],
      'needs' => ['required', 'json'],
      'neededAt' => ['required', 'date'],
      'recordNumber' => ['required', 'string', 'max:100'],
      'learningEnvironments' => ['required', 'json'],
      'localProposal' => ['required', 'string', 'max:1000'],
      'objective' => ['required', 'string', 'max:1000'],
      'observation' => ['required', 'string', 'max:1000'],
      'practicalPhases' => ['required', 'json'],
      'practiceHours' => ['required', 'integer'],
      'proposedAt' => ['required', 'date'],
      'project' => ['required', 'string', 'max:1000'],
      'public' => ['required', 'boolean'],
      'requiredInstallingSources' => ['required', 'json'],
      'setecName' => ['required',  'string', 'max:100'],
      'summary' => ['required',  'string', 'max:1000'],
      'targetGroups' => ['required',  'json'],
      'teachingStrategies' => ['required', 'json'],
      'techniquesRequisites' => ['required', 'json'],
      'theoreticalPhases' => ['required', 'json'],
      'theoryHours' => ['required', 'json'],
    ];
  }

  public function attributes()
  {
    return [
      'academicPeriod.id' => 'Id del periodo acad??mico',
      'area.id' => 'Id del ??rea',
      'entityCertification.id' => 'Id de la entidad certificadora',
      'career.id' => 'Id de la carrera',
      'category.id' => 'Id de la categor??a',
      'formationType.id' => 'Id del tipo de capacitaci??n',
      'certifiedType.id' => 'Id del tipo de certificado',
      'complianceIndicators.id' => 'Id del indicador de cumplimiento',
      'control.id' => 'Id del control',
      'courseType.id' => 'Id del tipo de curso',
      'frequency.id' => 'Id de la frecuencia',
      'modality.id' => 'Id de la modalidad',
      'meanVerification.id' => 'Id del medio de verificaci??n',
      'responsible.id' => 'Id del responsable del curso',
      'speciality.id' => 'Id de la especialidad',
      'state.id' => 'Id del estado del curso',
      'abbreviation' => 'Abreviaci??n',
      'alignment' => 'Alineaciones',
      'approvedAt' => 'Fecha de aprobaci??n',
      'bibliographies' => 'Bibliograf??as',
      'code' => 'C??digo',
      'cost' => 'Costo',
      'duration' => 'Duraci??n',
      'evaluationMechanisms' => 'Mecanismos de evaluaci??n',
      'expiredAt' => 'Fecha de expiraci??n',
      'facilities' => 'Facilidades',
      'free' => 'Gratuidad',
      'name' => 'Nombre',
      'needs' => 'Necesidades',
      'neededAt' => 'Fecha de necesidad',
      'recordNumber' => 'N??mero de record',
      'learningEnvironments' => 'Entornos de aprendizaje',
      'localProposal' => 'Prop??sito local',
      'objective' => 'Objetivo',
      'observation' => 'Observaci??n',
      'practicalPhases' => 'Fase pr??ctica',
      'practiceHours' => 'Horas pr??cticas',
      'proposedAt' => 'Fecha de propuesta',
      'project' => 'Proyecto',
      'public' => 'Publico',
      'requiredInstallingSources' => 'Fuentes de instalaci??n requeridas',
      'setecName' => 'Nombre de la setec',
      'summary' => 'Sumario',
      'targetGroups' => 'Grupos destinatarios',
      'teachingStrategies' => 'Estrategias de ense??anza',
      'techniquesRequisites' => 'Requisitos t??cnicos',
      'theoreticalPhases' => 'Fases te??ricas',
      'theoryHours' => 'Horas te??ricas'
    ];
  }
}
