<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>

<body>
    <table>
        @foreach ($datas as $key => $data)
        <tr>
            @foreach ($data as $item)
            <td style="padding-right: 1rem;">
                <p>{{ $item['name'] }}</p>
                {!! $item['qrcode'] !!}
            </td>
            @endforeach
        </tr>
        @endforeach
    </table>
</body>

</html>