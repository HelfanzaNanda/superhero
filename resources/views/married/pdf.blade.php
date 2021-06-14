<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="ie=edge">
	<title>PDF</title>
	<style>
		.table-body, .table-header {
		  font-family: Arial, Helvetica, sans-serif;
		  border-collapse: collapse;
		  width: 100%;
		}
		
		.table-body td, .table-body th, .table-header td {
		  border: 1px solid #ddd;
		  padding: 8px;
		}
		
		.table-body tr:nth-child(even), .table-header tr:nth-child(even){
			background-color: #f2f2f2;
		}
		
		.table-body tr:hover, .table-header tr:hover {
			background-color: #ddd;
		}
		
		.table-body th {
		  padding-top: 12px;
		  padding-bottom: 12px;
		  text-align: left;
		  background-color: #04AA6D;
		  color: white;
		}
		.table-header{
			margin-bottom: 1rem;
		}
		.images, .note{
			margin-left: 0.5rem;
		}
		</style>
</head>
<body>
	<table class="table-header">
		<tr>
			<td>Suami</td>
			<td>{{ $husband }}</td>
		</tr>
		<tr>
			<td>Istri</td>
			<td>{{ $wife }}</td>
		</tr>
	</table>
	<table class="table-body">
		<thead>
			<tr>
				<th>No</th>
				<th>Skill</th>
			</tr>
		</thead>
		<tbody>
			@foreach ($datas as $data)
				<tr>
					<td>{{ $loop->iteration }}</td>
					<td>{{ $data }}</td>
				</tr>
			@endforeach
		</tbody>
	</table>
</body>
</html>