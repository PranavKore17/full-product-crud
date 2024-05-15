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
    <table border="1px">
        <thead>
            <tr>
               <th colspan="8" align="center" style="background: #ffffb3"><b>User Data</b></th>
            </tr>
        <tr>
            <th style="background: #ccffff;border: 1px solid red; text-align: center;"><b>Name</b></th>
            <th style="background: #ccffff;border: 1px solid red; text-align: center;"><b>Address</b></th>
            <th style="background: #ccffff;border: 1px solid red; text-align: center;"><b>From Data</b></th>
            <th style="background: #ccffff;border: 1px solid red; text-align: center;"><b>To Data</b></th>
            <th style="background: #ccffff;border: 1px solid red; text-align: center;"><b>Country Name</b></th>
            <th style="background: #ccffff;border: 1px solid red; text-align: center;"><b>State Name</b></th>
            <th style="background: #ccffff;border: 1px solid red; text-align: center;"><b>City Name</b></th>
            <th style="background: #ccffff;border: 1px solid red; text-align: center;"><b>Image</b></th>
            <th style="background: #ccffff;border: 1px solid red; text-align: center;"><b>Status</b></th>
        </tr>
        </thead>
        <tbody>
        @foreach($users as $user)
            <tr>
                <td style="border: 1px solid red;text-align: center;">{{ $user->name }}</td>
                <td style="border: 1px solid red;text-align: center;">{{ $user->address }}</td>
                <td style="border: 1px solid red;text-align: center;">{{ $user->fromdate }}</td>
                <td style="border: 1px solid red;text-align: center;">{{ $user->todate }}</td>
                <td style="border: 1px solid red;text-align: center;">{{ $user->countries->country_name }}</td>
                <td style="border: 1px solid red;text-align: center;">{{ $user->states->state_name }}</td>
                <td style="border: 1px solid red;text-align: center;">{{ $user->cities->city_name }}</td>
                <td style="border: 1px solid red;text-align: center;">{{url('public/products/'.$user->image)}}</td>
                <td style="border: 1px solid red;text-align: center;">{{ $user->status }}</td>
            </tr>
        @endforeach
        </tbody>
    </table>
</body>
</html>