<!doctype html>
<html lang="en">
    <head>
        <title>WhatsApp</title>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no"/>
        <link
            href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"/>
    </head>

    <body>
        <div class="container p-5">
            @if(session('status'))
                <div class="alert alert-success">
                    {{ session('status') }}
                </div>
            @endif

            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            <div class="text-end w-25 pb-5">
                
                <form action="{{ route('import') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="input-group">
                        <input type="file" name="import_file" class="form-control" />
                        <button type="submit" class="btn btn-primary">Import</button>
                    </div>
                </form>

            </div>

            <table class="table">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Name</th>
                        <th scope="col">Number</th>
                        <th scope="col">Address</th>
                        <th scope="col">Url</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($hotels as $index => $hotel)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $hotel['name'] }}</td>
                            <td>{{ $hotel['number'] }}</td>
                            <td>{{ $hotel['street'] .  $hotel['location']}}</td>
                            <td>{{ $hotel['url'] }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        
        <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js"></script>
        <script src="https://cdn.cypress.io/latest/cypress.min.js"></script>
    
    </body>
</html>
