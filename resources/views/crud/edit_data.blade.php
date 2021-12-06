<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

    <title>Crud App</title>
  </head>
  <body>

    <!--Start for Crud table for practesing-->

    <div class="container">
        <a href="{{url('/crud')}}" class="btn btn-primary my-3">SHOW DATA</a>

        @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
        @endif

      


        <form action="{{url('/crud/update_data/'.$editData->id)}}" method="POST">
            @csrf

            <div class="form-group">
                <label for="">Name:</label>
                <input type="text" class="form-control" name="name" value="{{$editData->name}}" placeholder="Enter your name">
            </div>

            <div class="form-group">
                <label for="">Email:</label>
                <input type="email" class="form-control" name="email" value="{{$editData->email}}" placeholder="Enter your Email">
            </div>
            <input type="submit" class="btn btn-primary my-3" value="Submit">
        </form>


       

    </div>

    <!--Crud Table for practseing-->






  
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>

  
  </body>
</html>