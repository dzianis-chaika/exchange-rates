<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">

    <title>Exchange Rates</title>

    <style>
        table th, td {
            white-space: nowrap;
        }
    </style>
</head>

<body>
    <div class="container py-3">
        <form class="row" action="/">
            @if (count($dates))
            <div class="col-auto  mb-3">
                <select class="form-select" name="date">
                    @foreach ($dates as $date)
                    @php
                        $date = $date->format('d.m.Y');
                    @endphp
                    <option value="{{ $date }}" @selected(old('date') === $date)>
                        {{ $date }}
                    </option>
                    @endforeach
                </select>
            </div>
            <div class="col-auto mb-3">
                <button class="btn btn-primary">View</button>
            </div>
            @endif
            <div class="col-auto mb-3">
                <a class="btn btn-secondary" href="/logout">Logout</a>
            </div>
        </form>
        @if (count($currencies))
        <div class="table-responsive">
            <table class="table table-striped table-borderless">
                <thead>
                    <tr>
                        <th scope="col">ID</th>
                        <th scope="col">Code</th>
                        <th scope="col">Char. code</th>
                        <th scope="col">Name</th>
                        <th scope="col">Rate</th>
                        <th scope="col">Date</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($currencies as $currency)
                    <tr>
                        <td>{{ $currency->valuteID }}</td>
                        <td>{{ $currency->numCode }}</td>
                        <td>{{ $currency->charCode }}</td>
                        <td>{{ $currency->name }}</td>
                        <td>{{ $currency->value }}</td>
                        <td>{{ $currency->date->format('d.m.Y') }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @else
            <p class="text-center">No records found.</p>
        @endif
    </div>
</body>

</html>
