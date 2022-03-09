<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Asistencia-evaluacion</title>
</head>

<body>

	<br>

	<center>
		<table>

			<tr>

				<th colspan="5">Registro Fotografico</th>


			</tr>

			<tr>

				<th>Foto N.</th>


				<td>{{$photographicRecords->number_week}}</td>

				<td rowspan="6" style="width: 100%; height: 100%">{{$photographicRecords->url_image}}</td>

			</tr>

			<tr>

				<th>Descripcion</th>

				<td>{{$photographicRecords->description}}</td>

			</tr>

			<tr>

				<th>Fecha</th>

				<td>{{$photographicRecords->week_at}}</td>


			</tr>
			<tr>

				<th></th>

				<td>{{$detailPlanification->day->name}}</td>


			</tr>
			<tr>

				<th></th>

				<td>{{$detailPlanification->workday->name}}</td>


			</tr>

			<tr>

				<th></th>

				<td>{{$detailPlanification->started_time}}-{{$detailPlanification->ended_time}}</td>


			</tr>

		</table>


	</center>

	</div> <br><br>

	<div style="border: 1px solid black;">
		<p>Nota:</p>
		<p>Arhivo para uso digital, en el caso de requerir incluir más medios de verificación se pueden usar las celdas inferiores.</p>
	</div>



	<style>
		table,
		th,
		td {
			border: 1px solid black;
			border-collapse: collapse;


		}

		th,
		td {
			padding: 5px;
			text-align: center;
			height: auto;
			width: auto;

		}

		th {
			background-color: #008080;
		}

		.col-20 {
			font-family: 'calibri';
			position: absolute;
			margin-left: 0px;
			margin-right: 0px;





		}

		b {
			color: red;
		}

		div1,
		div2,
		div3,
		div4,
		div5 {
			float: left;
			height: 100%;
			margin-left: -5px;

		}



		div6,
		div7,
		div8,
		div9,
		div10 {
			float: left;
			height: 100%;
			margin-left: 40px;

		}

		div11,
		div12,
		div13,
		div14 {
			float: left;
			height: 100%;
			margin-left: 40px;

		}

		div15,
		div16,
		div17,
		div18 {
			float: left;
			height: 100%;
			margin-left: 40px;

		}
	</style>
</body>

</html>