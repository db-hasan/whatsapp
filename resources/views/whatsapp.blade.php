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
                        <th scope="col">url</th>
                        <th scope="col">Status</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($whatsapp  as $item)
                    <tr>
                        <th scope="row">{{$item->id}}</th>
                        <td>{{$item->name}}</td>
                        <td>{{$item->phone}}</td>
                        <td><a href="{{$item->url}}" target="_blank">{{$item->url}}</a></td>
                        {{-- <td><a href="#" onclick="openPopup('{{$item->url}}'); return false;">{{$item->url}}</a></td> --}}
                        <td class="{{ $item->status == 1 ? 'text-success' : 'text-danger' }}">
                            {{ $item->status == 1 ? 'WhatsApp' : 'Not found' }}
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        
        <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js"></script>
        <script src="https://cdn.cypress.io/latest/cypress.min.js"></script>
        
        {{-- <script>
            function openPopup(url) {
                var width = 800;
                var height = 600;
                var left = (window.innerWidth - width) / 2;
                var top = (window.innerHeight - height) / 2;
            
                var popup = window.open(url, '_blank', 'toolbar=yes,scrollbars=yes,resizable=yes,top=' + top + ',left=' + left + ',width=' + width + ',height=' + height);
                
                setTimeout(function() {
                    popup.close();
                }, 10000);
            }
        </script> --}}
    </body>
</html>
