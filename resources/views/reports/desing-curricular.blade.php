<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Diseño Curricular</title>
</head>

<body>
  <div class="col-20">
    <div>
      <b>FORMULARIO: b1</b>
      <h3 style="text-align:center ">DIRECCIÓN DE CALIFICACIÓN Y RECONOCIMIENTO <br>FORMULARIO DE DISEÑO CURRICULAR<br>
        - CAPACITACIÓN CONTINUA -</h3>
      <h4>Identificación del Curso.</h4>


    </div>
    <br><br>

    <div class="table_1 ">

      <table align="">


        <tr>
          <th class="column">Nombre del curso</th>
          <th>ÁREA</th>
          <th></th>
          <th>ESPEC.</th>
          <th></th>
          <th>ALINEACIONAL EJE DE LA ANC</th>

        </tr>
        <tr>
          <td>{{$course->name}}</td>
          <td>{{$course->area_id}}</td>
          <td>ADMINISTRACION Y LEGISLACION </td>
          <td>A.4</td>
          <td>Evaluacion de proyectos <br> (Economia financiera)</td>
          <td></td>

        </tr>
      </table>
    </div>


    <br> <br>

    <div class="table_2 ">

      <table align="">


        <tr>
          <th class="column">Tipo de participante</th>
          <th></th>
          <th>Modalidad</th>
          <th></th>
          <th>Duracion</th>

        </tr>
        <tr>
          <td>Docentes, facilitadores, capacitadores y <br> expertos en diferentes áreas técnicas, <br> tecnológicas y de especialización</td>
          <td></td>
          <td>Virtual</td>
          <td></td>
          <td>{{$course->duration}}   horas </td>

        </tr>
      </table>
    </div>


    <div class="col-11">
      <h4>Requisitos minimos de entrada al curso</h4>

       
      <h4>Tecnicos:</h4> 
      <p style="text-align:center "></p>
      

      <h4>Generales:</h4> 
      <p style="text-align:center "></p>


      <br>
      <h4>Objetivo del curso</h4>
      <br>
      <p style="text-align:center ">{{$course->objective}}</p>
      <br>
      <h4>Contenido del curso</h4>
      <div>Temas principales</div>
    </div>



    <div class="col-11 ">

      <table align="">

        <tr>
          <td>1. {{$topics->description}} </td>

        </tr>
        <tr>
          <td>2.{{$topics->description}}</td>

        </tr>
        <tr>
          <td> 3. {{$topics->description}} </td>

        </tr>
      </table>
    </div>
    <br><br>

    <div class="col-11 ">
      <p>Temas secundarios o sub temas </p>
      <br>
      <p>1.1. {{$topics->description}}</p>

      <p>2.1. {{$topics->description}}</p>

      <p>3.1. {{$topics->description}}</p>
    </div>
    <br><br>

    <div class="col-11 ">
      <div>Temas transversales </div>
      <br>

      <table align="">

        <tr>
          <td>{{$topics->description}}</td>

        </tr>
        <tr>
          <td> {{$topics->description}}</td>

        </tr>

      </table>
    </div>
    <br>
    <div class="col-11 ">
      <h4>Estrategias de enseñanza - aprendizaje</h4>
      <br>
      @foreach($course->teaching_strategies as $strategies) 
      <table align="">

        <tr>
          <td>{{$strategies}}</td>

        </tr>
      </table>
      @endforeach
    </div>
    <br>
    <div class="table_3 ">
      <h4>Mecanismos de evalucion</h4>
      <br>

      <table align="">
        <tr>
          <th colspan="2">Evaluación diagnóstica</th>
          <th colspan="2">Evaluación proceso formativo</th>
          <th colspan="2">Evaluación final</th>


        </tr>

        <tr>
          <th class="column">Tecnica</th>
          <th>Instrumento</th>
          <th>Tecnica</th>
          <th>Instrumento</th>
          <th>Tecnica</th>
          <th>Instrumento</th>


        </tr>
        <tr>
          <td>{{$course->tecnique}}</td>
          <td>Cuestionario escrito</td>
          <td>Talleres</td>
          <td>Entregable</td>
          <td>Proyecto</td>
          <td>Proeycto escrito-entragble final</td>


        </tr>
        <tr>
          <td></td>
          <td></td>
          <td>Tareas</td>
          <td>Entregable</td>
          <td>Examen</td>
          <td>Cuestionario escrito</td>

        </tr>
        <tr>
          <td></td>
          <td></td>
          <td>Prueba</td>
          <td>Cuestionario escrito</td>
          <td></td>
          <td></td>

        </tr>
      </table>
    </div>
    <br>
    <p>En caso de requerir más espacios, insertar filas.<br> * En cursos mayores a 40 horas</p>
    <br><br>
    <div class="table_4">
      <table align="">

        <tr>
          <th colspan="3">Entorno de Aprendizaje (Equipos, maquinarias, herramientas, materiales, materiales didácticos y de consumo para el desarrollo de la oferta de capacitación).</th>
        </tr>

        <tr>
          <th>Instalaciones</th>
          <th>Fase teórica</th>
          <th>Fase práctica</th>


        </tr>
        <tr>
          <td>Aula virtual</td>
          <td>x</td>
          <td></td>



        </tr>
        <tr>
          <td>Plataforma Google Suite Yavirac</td>
          <td></td>
          <td>x</td>

        </tr>
        <tr>
          <td colspan="3"></td>
        </tr>

        <tr>
          <td rowspan="2">Carga horaria</td>
          <td>Horas practicas</td>
          <td>{{$course->practice_hours}}   horas </td>
        </tr>


        <tr>
          <td>Horas teóricas</td>
          <td>{{$course->theory_hours}} horas</td>
        </tr>


        @foreach($course->bibliographies as $bibliographies) 
        <tr>
          <td>Bibliografia  </td>
          <td colspan="2">{{$bibliographies}}</td>
        </tr>
      </table>
      @endforeach

    </div>

    <br><br><br><br><br><br>
    <h4>.........................................................................<br>
      Firma del responsable del diseño curricular</h4>
    <br>
    <div1>Nombre y <br> apellido: </div1>
    <div2>LUIS PATRICIO VICENTE <br> GUTIEERRES</div2>
    <br><br>
    <div>Cedula</div>
    <div>17xxxxxxx</div>

    <div class="col-11">
      <table align="center">

        <tr>
          <td>Nota: En el caso de disponer sólo en archivos digitales, se puede insertar las firmas de resposabilidad como imagen en las celdas correspondientes.
          </td>

        </tr>
      </table>
    </div>

  </div>
  <style>
    table,
    th,
    td {
      border: 1px solid black;
      border-collapse: collapse;
      width: 80%;
      height: 30px;

    }

    th,
    td {
      padding: 10px;
      text-align: center;
      height: auto;
      width: auto;

    }

    th {
      background-color: #C0FFF4;
    }



    p {
      white-space: pre-line;
      font-size: 1em;

    }

    .col-20 {
      font-family: 'calibri';
      position: relative;


    }

    b {
      color: red;
    }

    body {
      margin-left: 50px;
      margin-right: 50px;
      margin-top: 500px;
      margin-bottom: 10px;
    }

    div1 {
      float: left;
      height: 100%
    }

    div2 {
      float: left;
      height: 100%;
      margin-left: 70px;
    }
  </style>
</body>

</html>