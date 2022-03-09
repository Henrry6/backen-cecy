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
					<br><br><br><br>
					<div class="posiciones_01" style="top: 11.3006em; left:16.45em;">
						<span class="stl_12 stl_08" style="word-spacing:0.01em;">
							<span class="stl_13" style="color: red;">FORMULARIO: e{{$course->id}} </span>
						</span>
					</div><br><br>
				</center>
				<center>

					<div class="posiciones_01" style="top: 14.1458em; left:16.0125em;">
						<span class="stl_14 stl_08" style="word-spacing:0.06em;"> REGISTRO DE PARTICIPANTES INSCRITOS Y MATRICULADOS </span>
					</div>
					<br><br>
				</center>

				<table>
					<tr>
						<th>PROVINCIA</th>
						<td>PICHINCHA</td>
						<th>TIPO DE CURSO</th>
						@if($course->course_type_id == 33)

						<td>ADMINISTRATIVO</td>
						@else
						<td>TECNICO </td>
						@endif


					</tr>
					<tr>
						<th>CANTON</th>
						<td>QUITO</td>

						<th>MODALIDAD DEL CURSO:</th>
						@if($course->course_type_id == 34)

						<td>Presencial</td>
						@else

						<td>Virtual</td>
						@endif

					</tr>
					<tr>
						<th>PARROQUIA</th>
						<td>CENTRO HISTORICO</td>
						<th>DURACIÓN DEL CURSO:</th>
						<td>{{$course->duration}} HORAS</td>


					</tr>
					<tr>
						<th>LOCAL DONDE SE DICTA</th>
						<td>{{$clasrroom->classroom->name}}</td>
						<th>FECHA DE INICIACION</th>
						<td>{{$planification->started_at}}</td>


					</tr>
					<tr>
						<th>CONVENIO</th>
						<td style="background-color: red;"></td>
						<th>FECHA PREVISTA DE FINALIZACION</th>
						<td>{{$planification->ended_at}}</td>
						<th>HORARIO DEL CURSO:</th>
						<td>{{$detailPlanification->started_time}} / {{$detailPlanification->ended_time}}</td>

					</tr>
					<tr>
						<th>NOMBRE DEL CURSO</th>
						<td>{{$course->name}}</td>
						<th>FECHA REAL DE FINALIZACION </th>
						<td>{{$planification->ended_at}}</td>
						<th>CODIGO DEL CURSO:</th>
						<td>{{$course->code}}</td>

					</tr>

				</table>
				<br><br> <br>
				<table>



					<tr>
						<th>APELLIDOS Y NOMBRES.</th>
						<th>DOCUMENTO DE IDENTIDAD</th>
						<th>SEXO</th>
						<th>EDAD / AÑOS</th>
						<th colspan="3">NIVEL DE INSTRUCCIÓN</th>
						<th colspan="4">DATOS DE LA EMPRESA</th>
						<th colspan="2">DATOS DEL PARTICIPANTE</th>
						<th>RESULTADOS</th>



					</tr>
					<tr>
						<td></td>
						<td></td>
						<td></td>
						<td></td>
						<td>PRI</td>
						<td>SEC</td>
						<td>SUP</td>
						<td>NOMBRE DE LA EMPRESA</td>
						<td>ACTIVIDAD DE LA EMPRESA</td>
						<td>DIRECCION DE LA EMPRESA</td>
						<td>TELEFONO</td>
						<td>DIRECCION DOMICILIARIA</td>
						<td>TELEFONOS</td>
						<td></td>


					</tr>

					@foreach($registrations as $information)


					<tr>
						<td>{{$information->participant->user->name}} {{$information->participant->user->lastname}}</td>
						<td>{{$information->participant->user->username}}</td>
						<td>{{$information->participant->user->sex->name}}</td>
						<td>{{$information->participant->user->birthdate}}</td>
						<td></td>
						<td></td>
						<td>{{$information}}</td>
						<td></td>
						<td></td>
						<td></td>

						<td></td>
						<td>{{$information->participant->user->address}}</td>
						<td>{{$information->participant->user->phone}}</td>
						<td>{{$information->state->name}}</td>

					</tr>
					@endforeach
		


				</table>
			</div>
			<br><br><br>
			<br><br>
			<div style="float: left;">
				<h4>FECHA DE ELABORACION:<br>......................................................................... </h4>
				<br><br>
				
			</div>

			<div style="float: right;">
			<h4>RESPONSABLE DE ELABORACION: <br>......................................................................... </h4>
			</div>
			<br><br><br><br><br>
			<div style="border: 1px solid black;">
				<p>Nota:</p>
				<p>Nota: Este formulario es para uso directo del Docente Responsable del Curso de Capacitación, como archvo digital, puede hacer uso del mismo colocando las firmas de responsabilidad como imagen dento del documento Excell.</p>
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