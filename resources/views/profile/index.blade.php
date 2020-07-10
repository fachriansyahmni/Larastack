<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Profile {{ $data->name }}</title>
    
    <link rel="stylesheet" href="{{ asset('bootstrap4/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/style.css')}}">
</head>
<body style="margin-top: 30px;">
    <ul class="nav justify-content-center">
            <li class="nav-item">
              <a class="nav-link" href="#">Tanya</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="#">Jawab</a>
            </li>
            <li class="nav-item">
              <a class="nav-link active" href="#">Profile</a>
            </li>
          </ul>
    <section>
        <div class="container">
            <div class="img-profile text-center">
                <img src="{{ asset('img/user-img-default.webp') }}" class="rounded shadow" alt="Img User" width="30%">
            </div>
            <div class="deskripsi mt-5">
                <p>
                    <samp>Nama Saya <u>{{ $data->name }}</u>.</samp><br>
                    <samp>Nama Lengkap Saya <u>{{ $data->nama_lengkap }}</u>- .</samp><br>
                    <samp>Saya memiliki reputasi {{$data->reputation}} poin.</samp>
                    <form action="" method="post">
                        @csrf
                    </form>
                </p>
            </div>
        </div>
    </section>

    <footer class="text-center mt-5">
       <a href="/" class="text-dark"><b>Lara</b>Stack</a>
    </footer>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"></script>
    <script src="{{ asset('bootstrap4/js/bootstrap.min.js') }}"></script>
</body>
</html>