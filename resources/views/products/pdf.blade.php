<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <title>Document</title>
</head>
<body>
    <table class='table table-bordered'>
        <thead>
            <tr>
                <th colspan="8" align="center" style="background: #ffffb3"><b>User Data</b></th>
            </tr>
        <tr>
            <th style="background: #ccffff"><b>Name</b></th>
            <th style="background: #ccffff"><b>Address</b></th>
            <th style="background: #ccffff"><b>From Data</b></th>
            <th style="background: #ccffff"><b>To Data</b></th>
            <th style="background: #ccffff"><b>Country Name</b></th>
            <th style="background: #ccffff"><b>State Name</b></th>
            <th style="background: #ccffff"><b>City Name</b></th>
            <th style="background: #ccffff"><b>Status</b></th>
            {{-- <th style="background: #ccffff"><b>Image</b></th> --}}
        </tr>
        </tr>
        </thead>
        <tbody>
            @foreach($products as $product)
            <tr>
                <td>{{ $product->name }}</td>
                <td>{{ $product->address }}</td>
                <td>{{ $product->fromdate }}</td>
                <td>{{ $product->todate }}</td>
                <td>{{ $product->countries->country_name }}</td>
                <td>{{ $product->states->state_name }}</td>
                <td>{{ $product->cities->city_name }}</td>
                {{-- <td>{{url('public/products/'.$product->image)}}</td> --}}
                <td>{{ $product->status }}</td>
            </tr>
        @endforeach
        </tbody>
    </table>
</body>

</html>