<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>informNeeds pdf</title>

</head>
<style>
table {
  table-layout: fixed;
  width: 100%;
  border-collapse: collapse;
  border: 3px solid purple;
}

thead th:nth-child(1) {
  width: 5%;
}

thead th:nth-child(2) {
  width: 5%;
}

thead th:nth-child(3) {
  width: 5%;
}

thead th:nth-child(4) {
  width: 5%;
}

th, td {
  padding: 5px;
}table {
  table-layout: fixed;
  width: 100%;
  border-collapse: collapse;
  border: 3px solid purple;
}

thead th:nth-child(1) {
  width: 5%;
}

thead th:nth-child(2) {
  width: 5%;
}

thead th:nth-child(3) {
  width: 5%;
}

thead th:nth-child(4) {
  width: 35%;
}

th, td {
  padding: 10px;
}
</style>

<body>

  <h1 ><img src="https://ignug.yavirac.edu.ec/assets/images/web/logo_login.png" style="height: 100px;"><h5  align="center">INSTITUTO SUPERIOR TECNOLÓGICO YAVIRAC</h5></h1>
  <h2 align="center">PROGRAMACIÓN DE CURSOS DE CAPACITACIÓN ANUAL</h2>
  <p>Año:</p>


  <table class="table table-striped table-hover">
    <thead>
      <tr>
        <th scope="col">Nro</th>
        <th scope="col">Área</th>
        <th scope="col">Nombre del curso</th>
        <th scope="col">¿curso OCC? SI/NO</th>
        <th scope="col">Fechas</th>
        <th scope="col">horario</th>
        <th scope="col">lugar</th>
        <th scope="col">nro de participantes</th>
        <th scope="col">docente</th>
        <th scope="col">responsable</th>
      </tr>
    </thead>
    <tbody>
      <tr>
        <th></th>
        <th></th>
        <td></td>
        <td></td>
        <td>inicia</td>
        <td>finaliza</td>
        <td>Desde</td>
        <td>Hasta</td>
        <td></td>
        <td></td>
      </tr>
      @foreach($courses as $course)
      <tr>
        <th scope="row">{{$course['id']}}</th>
        <td></td>
        <td>{{$course['name']}}</td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
      </tr>
      @endforeach

    </tbody>
  </table>

  

</body>

</html>