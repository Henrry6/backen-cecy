<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Informe final</title>
</head>

<body>
	<div class="col-20">

		<h4 style="text-align: right;">CODIGO DEL CURSO: {{$course->code}}</h4>
		<h4 style="text-align: right;">FORMULARIO: b2 </h4>
		<h3 style="text-align:center ">INSTITUTO SUPERIOR TECNOLÓGICO YAVIRAC</h3>
		<h3 style="text-align:center ">INFORME FINAL DEL CURSO</h3>
		<br>

		<h4>Nombre del docente:&nbsp;&nbsp; </h4>
		<div1> {{$planification->responsible_course}} </div1>

		<h4>Nombre del curso:</h4>
		<div2>{{$course->name}} </div2>


		<h4>Tipo de curso: {{$course->course_type_id}}</h4>
		<div3>Administrativo</div3>
		<div4>Tecnico</div4>

		<h4>Modalidad del curso:{{$course->modality_id}}</h4>
		<div6>Presencial</div6>
		<div7>Virtual</div7>
		<br>

		<h4>Contenido del curso (Temas generales)</h4>
		<div9>1 {{$topics->description}}</div9>
		<div10>2 {{$topics->description}}...........................</div10>
		<div11>3 {{$topics->description}}............................</div11>
		<div12>4 {{$topics->description}}........................</div12>
		<div13>5 {{$topics->description}}.......................</div13>
		<div14>6 {{$topics->description}}...........................</div14>

		<div15>Duracion del curso: </div15>
		<div16>{{$course->duration}}</div16>
		<div17>horas</div17>
		<div18>Lugar donde se dicta:</div18>
		<div19>CAMPUS YAVIRAC</div19>
		<div20>Canton:</div20>
		<div21>Quito</div21>
		<div22>Horario del curso:</div22>
		<div23>7.00 </div23>
		<div24>9.00</div24>
		<div25>Horario del curso: </div25>
		<div26>18.00 </div26>
		<div27>20.00</div27>
		<div28>Dias: </div28>
		<div29>Lunes-Viernes</div29>
		<div30>Sabados</div30>
		<div31>Lunes-Domin.</div31>
		<div32>Domingos</div32>
		<div33>Dias: </div33>
		<div34>Lunes-Viernes</div34>
		<div35>Sabados</div35>
		<div36>Lunes-Domin.</div36>
		<div37>Domingos</div37>
		<br><br>
		<br><br>
		<br><br>
		<br><br>
		<br><br>
		<br><br>
		<br><br>
		<br><br>
		<br><br>
		<br><br>
		<br><br>

		<div38>Fecha de iniciacion:</div38>
		<div39>Fecha prevista de finalizacion:</div39>

		<div40>Fecha real de finalizacion:</div40>

		<div41>Participantes inscritos:</div41>
		<div42>Participantes retirados:</div42>
		<div43>Participantes reprobados:</div43>
		<div44>Participantes aprobados:</div44>
		<br>
		<div45>Observaciones: {{$course->observations}}</div45>

		<br>
		<br>
		<br>
		<br>
		<br>
		<br>
		<br>
		<br>
		<br>
		<br>
		<br>
		<br>
		<br>
		<br>
		<br><br>
		<br>
		<br>
		<br>
		<br>
		<br>
		<br>
		<br>
		<br>
		<br>


		<div class="table_1 ">

			<table align="center">


				<tr>
					<th class="column">PARTICIPANTES</th>
					<th>HOMBRES</th>
					<th>MUJERES</th>
					<th>TOTAL</th>
					<th>OBSERVACIONES</th>

				</tr>
				<tr>
					<td>INSCRITOS:</td>
					<td> 40 </td>
					<td>37 </td>
					<td>77</td>
					<td></td>

				</tr>
				<tr>
					<td>RETIRADOS:</td>
					<td> 13 </td>
					<td>6 </td>
					<td>19</td>
					<td></td>
				</tr>

				<tr>
					<td>REPROBADOS:</td>
					<td> 13 </td>
					<td>3 </td>
					<td>3</td>
					<td></td>
				</tr>

				<tr>
					<td>APROBADOS</td>
					<td> 25 </td>
					<td>27 </td>
					<td>52</td>
					<td></td>
				</tr>

			</table>
		</div>
		<br>
		<br>
		<br>
		<br><br>
		<br><br>
		<br><br>
		<br>
		<div class="col-12">
			<div50> DOCENTE</div50>
			<div51> FECHA</div51>

		</div>
		<div class="table-2">
			<table align="center">

				<tr>
					<td>Nota: Para uso exclusivo del docente, en archivo digital se copian únicamente las <br>
						firmas de responsabilidad del docente en el documento.
					</td>

				</tr>
			</table>
		</div>

	</div>


	<style>
		div1 {
			float: left;
			height: 100%;
			margin-left: 200px;
			font-weight: bold;
			margin-top: -40px;
			color: blue;


		}

		div2 {
			float: left;
			height: 100%;
			margin-left: 200px;
			font-weight: bold;
			margin-top: -40px;
			color: blue;


		}

		div3 {
			float: left;
			height: 100%;
			margin-left: 200px;
			font-weight: bold;
			margin-top: -40px;

		}

		div4 {
			float: left;
			height: 100%;
			margin-left: 200px;
			font-weight: bold;
			margin-top: -40px;
			margin-left: 500px;

		}

		div6 {
			float: left;
			height: 100%;
			margin-left: 200px;
			font-weight: bold;
			margin-top: -40px;

		}

		div7 {
			float: left;
			height: 100%;
			margin-left: 200px;
			font-weight: bold;
			margin-top: -40px;
			margin-left: 500px;

		}

		div9 {
			float: left;
			height: 100%;
			margin-left: 20px;
			margin-top: 5px;
			color: blue;

		}

		div10 {
			float: left;
			height: 100%;
			margin-left: -70px;
			margin-top: 30px;
			color: blue;


		}

		div11 {
			float: left;
			height: 100%;
			margin-left: -180px;
			margin-top: 55px;
			color: blue;


		}

		div12 {
			float: left;
			height: 100%;
			margin-left: -180px;
			margin-top: 80px;
			color: blue;


		}

		div13 {
			float: left;
			height: 100%;
			margin-left: -180px;
			margin-top: 105px;
			color: blue;


		}

		div14 {
			float: left;
			height: 100%;
			margin-left: -180px;
			margin-top: 130px;
			color: blue;



		}

		div15 {
			float: left;
			height: 100%;
			margin-left: -220px;
			font-weight: bold;
			margin-top: 170px;

		}

		div16 {
			float: left;
			height: 100%;
			margin-left: 0px;
			font-weight: bold;
			margin-top: 170px;

		}

		div17 {
			float: left;
			height: 100%;
			margin-left: 40px;
			font-weight: bold;
			margin-top: 170px;

		}

		div18 {
			float: left;
			height: 100%;
			margin-left: -322px;
			font-weight: bold;
			margin-top: 200px;

		}

		div19 {
			float: left;
			height: 100%;
			margin-left: -100px;
			font-weight: bold;
			margin-top: 200px;

		}

		div20 {
			float: left;
			height: 100%;
			margin-left: 100px;
			font-weight: bold;
			margin-top: 200px;

		}

		div21 {
			float: left;
			height: 100%;
			margin-left: 10px;
			font-weight: bold;
			margin-top: 200px;

		}

		div22,
		div25 {
			float: left;
			height: 100%;
			margin-right: 300px;
			font-weight: bold;
			margin-top: 20px;

		}

		div23,
		div26 {
			float: left;
			height: 100%;
			margin-left: -250px;
			font-weight: bold;
			margin-top: 20px;

		}

		div24,
		div27 {
			float: left;
			height: 100%;
			margin-left: -190px;
			font-weight: bold;
			margin-top: 20px;

		}

		div28 {
			float: left;
			height: 100%;
			margin-left: -100px;
			font-weight: bold;
			margin-top: 20px;

		}

		div29 {
			float: left;
			height: 100%;
			margin-left: -50px;
			margin-top: 20px;

		}

		div30 {
			float: left;
			height: 100%;
			margin-left: 12px;
			margin-top: 20px;

		}

		div31 {
			float: left;
			height: 100%;
			margin-left: 12px;
			margin-top: 20px;

		}

		div32 {
			float: left;
			height: 100%;
			margin-left: 12px;
			margin-top: 20px;

		}

		div33 {
			float: left;
			height: 100%;
			margin-left: -419px;
			margin-top: -20px;
			font-weight: bold;


		}

		div34 {
			float: left;
			height: 100%;
			margin-left: -370px;
			margin-top: -20px;


		}

		div35 {
			float: left;
			height: 100%;
			margin-left: -262px;
			margin-top: -20px;



		}

		div36 {
			float: left;
			height: 100%;
			margin-left: -180px;
			margin-top: -20px;



		}

		div37 {
			float: left;
			height: 100%;
			margin-left: -70px;
			margin-top: -20px;



		}

		div38 {
			float: left;
			height: 100%;
			margin-left: 0px;
			margin-top: -100px;
			font-weight: bold;




		}

		div39 {
			float: left;
			height: 100%;
			margin-left: 0px;
			margin-top: -60px;
			font-weight: bold;


		}

		div40 {
			float: left;
			height: 100%;
			margin-left: 350px;
			margin-top: -100px;
			font-weight: bold;


		}

		div41 {
			float: left;
			height: 100%;
			margin-left: 0px;
			margin-top: -15px;
			font-weight: bold;


		}

		div42 {
			float: left;
			height: 100%;
			margin-left: 172px;
			margin-top: -15px;
			font-weight: bold;


		}

		div43 {
			float: left;

			height: 100%;
			margin-left: 350px;
			margin-top: 15px;
			font-weight: bold;


		}

		div44 {
			float: left;
			height: 100%;
			margin-left: -550px;
			margin-top: 15px;
			font-weight: bold;


		}

		div45 {
			float: left;
			height: 100%;
			margin-left: -550px;
			margin-top: 50px;
			font-weight: bold;
			color: blue;


		}

		



		.col-20 {
			font-family: 'Arial';
			position: relative;
			margin-left: 40px;
			margin-right: 40px;
			

		}

		div50 {
			float: left;
			height: 100%;
			margin-left: 200px;
			margin-top: -70px;
			font-weight: bold;
		
		}
		div51 {
			float: left;
			height: 100%;
			margin-left: 600px;
			margin-top: -70px;
			font-weight: bold;
		
		}
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
	</style>
</body>

</html>