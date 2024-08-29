<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Hotel Rooms</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    </head>
    <body>
    <section class="content">
        <div class="row">
            <div class="col-md-12">
                        @foreach ($hotel->images as $image)
                            <div class="sheri coll">
                                <img class="w-100" src="{{ $image->image_url }}" alt="{{ $image->image }}">
                                <br/>
                            </div>
                        @endforeach
                </div>
            </div>
        </div>
    </section>
    </body>
</html>