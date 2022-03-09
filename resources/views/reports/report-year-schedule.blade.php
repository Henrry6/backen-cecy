<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Informe necesidades</title>
</head>

<body>
  <div class="pociciones_recuadros">
    <div>
      <img src="https://ignug.yavirac.edu.ec/assets/images/web/logo_login.png" alt="" />
    </div>
    <div class="stl_view">
      <div class="stl_05 stl_06">
        <center>
          <br><br><br><br>
          <div class="posiciones_01" style="top: 11.3006em; left:16.45em;">
            <span class="stl_12 stl_08" style="word-spacing:0.01em;">
              <span class="stl_13">INSTITUTO TECNOLÓGICO SUPERIOR YAVIRAC </span>
            </span>
          </div>
        </center>
        <center>

          <div class="posiciones_01" style="top: 14.1458em; left:16.0125em;">
            <span class="stl_14 stl_08" style="word-spacing:0.06em;">PROGRAMACIÓN MENSUAL </span>
          </div>
        </center>
        <br><br> <br><br>

        <div style="float: right;">
          <p>Año:4654</p>
        </div>
        <br><br>
        <table>



          <tr>
            <th>Nro.</th>
            <th>Sector</th>
            <th>Area</th>
            <th>Nombre Del Curso</th>
            <th>¿Curso OCC ?</th>
            <th colspan="2">Fechas</th>
            <th colspan="2">Horario</th>
            <th>Lugar Del Curso Dictado</th>
            <th>Nro. De Participantes</th>
            <th>Docente</th>
            <th>Responsable</th>



          </tr>
          <tr>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td>INICIA</td>
            <td>FINALIZA</td>
            <td>DESDE</td>
            <td>HASTA</td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>



          </tr>
          @foreach($planifications as $planification)
          <tr>
          
            <td>{{$planification->id}}</td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>

            <td>{{$planification->started_at}}</td>
            <td>{{$planification->ended_at}}</td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>

          </tr>
          @endforeach

        </table>
      </div>
      <br><br><br>
      <br><br>
      <div style="float: left;">
        <h4>Elaborado por:<br>.........................................................................<br>
          Firma: Coordinador de Vinculación con la Comunidad </h4>
        <br><br>
        <h4>Revisado por: <br>.........................................................................<br>
          Firma: Vicerrector ITS </h4>
      </div>
      <div style="float: right;">
        <h4>Aprobado por: <br>.........................................................................<br>
          Firma: Representante del OCS.</h4>
        <br><br>
      </div>
      <br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>
      <div style="border: 1px solid black;">
        <p>Nota:</p>
        <p>Este documento deberá generarse de manera mensual sobre la planificación de cursos de capacitación tanto SENESCYT como OCC, respaldado en el Instructivo Capacitación - Certificación por Competencias Laborales de SENESCYT</p>
      </div>
    </div>
  </div>
  <STYLE>
    table,
    th,
    td {
      border: 1px solid black;
      border-collapse: collapse;
      width: 100%;

    }

    th,
    td {
      padding: 5px;
      text-align: center;
      height: auto;
      width: auto;

    }

    th {
      background-color: #C0FFF4;
    }

    .col-20 {
      font-family: 'calibri';
      position: absolute;
      margin-left: 0px;
      margin-right: 0px;





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

    th,
    td {
      padding: 5px;
    }

    div2 {
      float: left;
      height: 100%;
      margin-left: 70px;
    }

    div1 {
      float: left;
      height: 100%
    }

    .stl_07 {
      font-size: 0.81em;
      font-family: "MNVHEN+Arial-BoldItalicMT";
      color: #000000;
      line-height: 1.045208em;
    }

    .stl_08 {
      letter-spacing: -0.01em;
    }

    .stl_09 {
      font-size: 0.81em;
      font-family: "DTOMOW+ArialMT";
      color: #000000;
      line-height: 1.045208em;
    }

    .stl_10 {
      letter-spacing: 0em;
    }

    .stl_11 {
      font-size: 0.98em;
      font-family: "MNVHEN+Arial-BoldItalicMT";
      color: black;
      line-height: 1.047363em;
    }

    .stl_12 {
      font-size: 1.14em;
      font-family: "ISDLRO+Arial-BoldMT";
      color: #000000;
      line-height: 1.048908em;
    }

    .stl_13 {
      letter-spacing: -0.02em;
    }

    .stl_14 {
      font-size: 1.46em;
      font-family: "MNVHEN+Arial-BoldItalicMT";
      color: #000000;
      line-height: 1.043776em;
    }

    .stl_15 {
      font-size: 0.89em;
      font-family: "ISDLRO+Arial-BoldMT";
      color: #000000;
      line-height: 1.046383em;
    }

    .stl_16 {
      font-size: 0.81em;
      font-family: "DTOMOW+ArialMT";
      color: black;
      line-height: 1.045208em;
    }

    .stl_17 {
      font-size: 0.81em;
      font-family: "ISDLRO+Arial-BoldMT";
      color: #000000;
      line-height: 1.045208em;
    }

    .stl_18 {
      font-size: 0.81em;
      font-family: "DTOMOW+ArialMT";
      color: black;
      line-height: 1.045208em;
    }

    .stl_19 {
      font-size: 0.65em;
      font-family: "DTOMOW+ArialMT";
      color: #000000;
      line-height: 1.041992em;
    }

    .stl_20 {
      font-size: 0.65em;
      font-family: "DTOMOW+ArialMT";
      color: black;
      line-height: 1.041992em;
    }

    .stl_21 {
      font-size: 0.81em;
      font-family: "ISDLRO+Arial-BoldMT";
      color: black;
      line-height: 1.045208em;
    }

    .stl_22 {
      font-size: 0.89em;
      font-family: "MNVHEN+Arial-BoldItalicMT";
      color: #000000;
      line-height: 1.046383em;
    }
  </STYLE>
</body>

</html>