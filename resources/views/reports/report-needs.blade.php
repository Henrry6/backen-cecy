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
					<span class=" stl_07 stl_08" style="word-spacing:0.05em;top: 0em; left:44.7em; position: absolute;white-space: nowrap;">CÓDIGO DEL CURSO: {{ $planification->code}} </span>
				</div>
				<div class="posiciones_01" style="top: 0.7265em; left:42.7em; position: absolute;white-space: nowrap;">
					<span class="stl_11 stl_08" style="word-spacing:0.09em;">FORMULARIO: f {{ $planification->id }} </span>
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
					<span class="stl_15 stl_08" style="word-spacing:0.07em;">Nombre del Docente:LUIS PATRICIO VICENTE </span>
				</div>
				<br>
				<div class="posiciones_01" style="top: 21.1243em; left:6.0125em;">
					<span class="stl_15 stl_08" style="word-spacing:0.06em;">Nombre del Curso: {{ $planification->name }}</span>
				</div>
				<br>
				@if($planification->course_type_id == 33)
				<div class="posiciones_01" style="top: 23.7095em; left:17.95em;">
					<span class="stl_17 stl_10"> Tipo de curso: ADMINISTRATIVO </span>
				</div>
				@else
				<div class="posiciones_01" style="top: 23.7095em; left:17.95em;">
					<span class="stl_17 stl_10"> Tipo de curso: TÉCNICO</span>
				</div>
				@endif
				<br>


				@if($planification->course_type_id == 34)

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
						@foreach( $planification->needs as $need)
						<table>
							<tr>

								<td width="350px" class="column-right">{{$need}}</td>
							</tr>
							@endforeach
						</table>
					</span>
				</div>
				<br>

				<div class="posiciones_01" style="top: 40.3743em; left:6.0125em;">
					<span class="stl_15 stl_08" style="word-spacing:0.07em;">Duración del curso: {{$planification->duration}} horas</span>
				</div>
				<br>

				<div class="posiciones_01" style="top: 42.9993em; left:6.0125em;">
					<span class="stl_15 stl_08" style="word-spacing:0.05em;">Lugar / Lugares donde se dictará (Indicar si necesitará salidas de campo)
					</span>
				</div>
				<div class="posiciones_01" style="top: 46.7768em; left:6.0125em;">
					<span class="stl_15 stl_08" style="word-spacing:0.06em;">

						<table border="1px">
							<tr>

								<th width="350px" class="column-right">Horario Curso:</th>
								<td width="350px" class="column-right"></td>
								<th width="350px" class="column-right">a</th>
								<td width="350px" class="column-right"></td>
								<th width="350px" class="column-right">Días</th>
								<td width="350px" class="column-right"></td>
							</tr>
						</table>
					</span>
				</div>
				<br>
				<div class="posiciones_01" style="top: 57.4368em; left:6.0125em;">
					<span class="stl_15 stl_08" style="word-spacing:0.07em;">Participantes a ser inscritos: </span>
				</div>

				<div class="posiciones_01" style="top: 60.0618em; left:6.0125em;">
					<span class="stl_22 stl_08" style="word-spacing:0.05em;">Resumen del Curso y Posible Proyecto: </span>
				</div>
				<div class="posiciones_01" style="top: 60.147em; left:29.2em;">
					<span class="stl_16 stl_08" style="word-spacing:0.06em;">El curso busca desarrollar las competencias necesarias en los </span>
				</div>
				<div class="posiciones_01" style="top: 61.4595em; left:6.0125em;">
					<span class="stl_16 stl_08" style="word-spacing:0.08em;">profesionales interesados en ser Formador de Formadores, facilitando las perspectivas, herramientas y técnicas requeridas </span>
				</div>
				<div class="posiciones_01" style="top: 62.772em; left:6.0125em;">
					<span class="stl_16 stl_08" style="word-spacing:0.05em;">Un instructor puede ser de la setec o docente de la senescyt'</span>
				</div>
				<div class="posiciones_01" style="top: 64.0845em; left:6.0125em;">
					<span class="stl_16 stl_08" style="word-spacing:0.05em;">1. El aprendizaje y la formación en adultos </span>
				</div>
				<div class="posiciones_01" style="top: 65.397em; left:6.0125em;">
					<span class="stl_16 stl_08" style="word-spacing:0.06em;">2. El contexto de la formación profesional </span>
				</div>
				<div class="posiciones_01" style="top: 66.7095em; left:6.0125em;">
					<span class="stl_16 stl_08" style="word-spacing:0.06em;">3. El proceso de formación profesional </span>
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
				<div class="posiciones_01" style="top: 79.8345em; left:45.2em;">
					<span class="stl_16 stl_10">26-feb-21</span>
				</div>
				<div class="posiciones_01" style="top: 81.0618em; left:9.7em;">
					<span class="stl_22 stl_08" style="word-spacing:0.02em;">REPRESENTANTE DEL OCS </span>
				</div>
				<div class="posiciones_01" style="top: 81.0618em; left:45.3875em;">
					<span class="stl_22 stl_10">FECHA</span>
				</div>
				<div class="posiciones_01" style="top: 86.397em; left:45.2em;">
					<span class="stl_16 stl_10">26-feb-21</span>
				</div>
				<div class="posiciones_01" style="top: 87.6243em; left:12.3875em;">
					<span class="stl_22 stl_08">VICERRECTOR</span>
				</div>
				<div class="posiciones_01" style="top: 87.6243em; left:45.3875em;">
					<span class="stl_22 stl_10">FECHA</span>
				</div>
				<div class="posiciones_01" style="top: 93.7688em; left:6.2em;">
					<span class="stl_17" style="word-spacing:0em;">Nota</span>
					<span class="stl_09 stl_08" style="word-spacing:0.05em;">: Documento que deberá ser aprobado por parte del Organo Colegiado Superior (OCS) y del Vicerrector del Instituto, tal como lo </span>
				</div>
				<div class="posiciones_01" style="top: 94.7031em; left:6.2em;">
					<span class="stl_09 stl_08" style="word-spacing:0.05em;">indica la normativa y el Acuerdo 118 (Instructivo de Capacitación</span>
				</div>
				<div class="posiciones_01" style="top: 95.6374em; left:9.0125em;">
					<span class="stl_09 stl_08" style="word-spacing:0.06em;">que sea un registro digital, se adjuntan las firmas de responsabilidad como fotografìas en las celdas correspondientes </span>
				</div>
			</div>
		</div>
	</div>
	<STYLE>
		/* 		sup {
			top: -0.4em;
			vertical-align: baseline;
			position: relative;
		}

		sub {
			top: 0.4em;
			vertical-align: baseline;
			position: relative;
		}

		.posiciones_01 {
			position: absolute;
			white-space: nowrap;
		}

		.pociciones_recuadros {
			height: 108.5833em;
			font-size: 1em;
			margin: 0em;
			line-height: 0.0em;
			display: block;
			border-style: none;
			width: 61.41667em;
		}

		.stl_03 {
			position: relative;
		}

		.stl_04 {
			width: 100%;
			position: absolute;
			pointer-events: none;
		}

		.stl_05 {
			position: relative;
			width: 61.41667em;
		}

		.stl_06 {
			height: 10.85833em;
		}

		.ie .stl_06 {
			height: 108.5833em;
		} */

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