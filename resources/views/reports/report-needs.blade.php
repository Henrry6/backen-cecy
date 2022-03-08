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
				<div class="posiciones_01"">
					<span class=" stl_07 stl_08" style="word-spacing:0.05em;top: 0em; left:44.7em; position: absolute;white-space: nowrap;">CÓDIGO DEL CURSO: {{ $course->code}} </span>
				</div>
				<div class="posiciones_01" style="top: 0.7265em; left:42.7em; position: absolute;white-space: nowrap;">
					<span class="stl_11 stl_08" style="word-spacing:0.09em;">FORMULARIO: f {{ $course->id }} </span>
				</div>
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
						<span class="stl_14 stl_08" style="word-spacing:0.06em;">INFORME DE NECESIDAD DEL CURSO </span>
					</div>
				</center>
				<br><br> <br><br>
				<div class="posiciones_01" style="top: 18.6243em; left:6.0125em;">
					<span class="stl_15 stl_08" style="word-spacing:0.07em;">Nombre del Docente:{{$planification->responsible_course}} </span>
				</div>
				<br>
				<div class="posiciones_01" style="top: 21.1243em; left:6.0125em;">
					<span class="stl_15 stl_08" style="word-spacing:0.06em;">Nombre del Curso: {{$course->name}}</span>
				</div>
				<br>
				@if($course->course_type_id == 33)
				<div class="posiciones_01" style="top: 23.7095em; left:17.95em;">
					<span class="stl_17 stl_10"> Tipo de curso: ADMINISTRATIVO </span>
				</div>
				@else
				<div class="posiciones_01" style="top: 23.7095em; left:17.95em;">
					<span class="stl_17 stl_10"> Tipo de curso: TÉCNICO</span>
				</div>
				@endif
				<br>


				@if($course->course_type_id == 34)

				<div class="posiciones_01" style="top: 26.2095em; left:17.95em;">
					<span class="stl_17 stl_10"> Modalidad del curso: PRESENCIAL</span>
				</div>
				@else
				<div class="posiciones_01" style="top: 26.2095em; left:17.95em;">
					<span class="stl_17 stl_10">Modalidad del curso: VIRTUAL</span>
				</div>
				@endif
				<br>

				<div class="posiciones_01" style="top: 29.8743em; left:6.0125em;">
					<span class="stl_15 stl_08" style="word-spacing:0.07em;">Necesidad del Curso: </span>
				</div>
				<br>
				<div class="posiciones_01" style="top: 32.2688em; left:7.8626em;">
					<span class="stl_16 stl_08" style="word-spacing:0.05em;">
						@foreach($course->needs as $need)

						<table>
							<tr>

								<td width="350px" class="column-right">{{$need}}</td>
							</tr>
						</table>
						@endforeach
						@foreach($planification->needs as $need)

						<table>
							<tr>

								<td width="350px" class="column-right">{{$need}}</td>
							</tr>
						</table>
						@endforeach
					</span>
				</div>
				<br>

				<div class="posiciones_01" style="top: 40.3743em; left:6.0125em;">
					<span class="stl_15 stl_08" style="word-spacing:0.07em;">Duración del curso: {{$course->duration}} horas</span>
				</div>
				<br>

				<div class="posiciones_01" style="top: 42.9993em; left:6.0125em;">
					<span class="stl_15 stl_08" style="word-spacing:0.05em;">Lugar / Lugares donde se dictará (Indicar si necesitará salidas de campo)
					</span>
				</div>
				<div class="posiciones_01" style="top: 46.7768em; left:6.0125em;">
					<span class="stl_15 stl_08" style="word-spacing:0.06em;">
						@foreach($days as $day)
						<table class="table">
							<tr>

								<th class="th">Horario Curso:</th>
								<td class="td">{{$day->started_time}}</td>
								<th class="td">a</th>
								<td class="td">{{$day->ended_time}}</td>
								<th class="td">Días</th>
								<td class="td">{{$day->day->name}}</td>
							</tr>
						</table>
						@endforeach
					</span>
				</div>
				<br>
				<div class="posiciones_01" style="top: 46.7768em; left:6.0125em;">
					<span class="stl_15 stl_08" style="word-spacing:0.06em;">
						<table class="table">
							<tr>

								<th class="th">Fecha iniciación:</th>
								<td class="td">{{$planification->started_at}}</td>
								<th class="td">Fecha real de finalización</th>
								<td class="td">{{$planification->ended_at}}</td>
							</tr>
						</table>

					</span>
				</div>
				<br>
				<div class="posiciones_01" style="top: 57.4368em; left:6.0125em;">
					<span class="stl_15 stl_08" style="word-spacing:0.07em;">Participantes a ser inscritos: </span>
				</div>
				<div>
					<span>
						@foreach($classrooms as $classroom)
						<table class="table">
							<tr>
								<th width="350px" class="th">{{$classroom->classroom->capacity}}</th>
							</tr>
						</table>
						@endforeach
					</span>
				</div>
				<div class="posiciones_01" style="top: 60.0618em; left:6.0125em;">
					<span class="stl_22 stl_08" style="word-spacing:0.05em;">Resumen del Curso y Posible Proyecto: </span>
				</div>
				<div class="posiciones_01" style="top: 46.7768em; left:6.0125em;">
					<span class="stl_15 stl_08" style="word-spacing:0.06em;">


						<table class="table">
							<tr>
								<td width="350px" class="th">{{$course->summary}}</td>
							</tr>
						</table>
					</span>
				</div>
				<div class="posiciones_01" style="top: 73.1868em; left:6.0125em;">
					<span class="stl_22 stl_08" style="word-spacing:0.05em;">Indicar a que población se encuentra dirigido el curso: </span>
				</div>
				<div class="posiciones_01" style="top: 73.272em; left:35.7em;">
					<span class="stl_16 stl_10" style="word-spacing:0em;">Docentes, facilitadores, capacitadores</span>
				</div>
				<div class="posiciones_01" style="top: 74.5845em; left:6.0125em;">
					<span class="stl_16 stl_08" style="word-spacing:0.07em;">expertos en diferentes áreas técnicas, tecnológicas y de especialización </span>
				</div>
				<br><br>
				<div style="float: left;">
					<h4>.........................................................................<br>
						REPRESENTANTE DEL OCS</h4>
					<br><br>
					<h4>.........................................................................<br>
						VICERRECTOR </h4>
				</div>
				<div style="float: right;">
					<h4>.........................................................................<br>
						FECHA</h4>
					<br><br>
					<h4>.........................................................................<br>
						FECHA </h4>
				</div>
				<br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>
				<div style="border: 1px solid black;">
					<p>Nota:</p>
					<p>Documento que deberá ser aprobado por parte del Organo Colegiado Superior (OCS) y del Vicerrector del Instituto, tal como lo indica la normativa y el Acuerdo 118 (Instructivo de Capacitación - Certificación por Competencias Laborales SENESCYT), en el caso que sea un registro digital, se adjuntan las firmas de responsabilidad como fotografìas en las celdas correspondientes.</p>
				</div>
			</div>
			<br><br><br>


		</div>
	</div>
	<STYLE>
		.table,
		.th,
		.td {
			border: 1px solid black;
			border-collapse: collapse;
			width: 50%;
			height: 30px;

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