<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <meta http-equiv="X-UA-Compatible" content="ie=edge"/>
  <title>Register</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet" />
</head>
<body>

<section class="vh-100 d-flex align-items-center justify-content-center" style="background: blue;">
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-md-8 col-lg-6 col-xl-5">
        <div class="card text-white bg-dark rounded-4 shadow">
          <div class="card-body p-5">

            <div class="text-center mb-4">
              <h2 class="fw-bold text-uppercase">Register</h2>
              <p class="text-white-50">Masukan data untuk membuat akun</p>
            </div>

            <form action="{{ route('actionRegister') }}" method="POST">
              @csrf

              <div class="form-floating mb-3 text-dark">
                <input type="email" id="email" name="email" class="form-control" placeholder="Email" value="{{ old('email') }}" required>
                <label for="email"><i class="bi bi-envelope-fill me-2"></i>Email</label>
              </div>

              <div class="form-floating mb-3 text-dark">
                <input type="text" id="name" name="name" class="form-control" placeholder="Username" value="{{ old('name') }}" required>
                <label for="name"><i class="bi bi-person-fill me-2"></i>Name</label>
              </div>

              <div class="form-floating mb-3 text-dark">
                <input type="password" id="password" name="password" class="form-control @error('password') is-invalid @enderror" placeholder="Password" required>
                <label for="password"><i class="bi bi-lock-fill me-2"></i>Password</label>
                @error('password')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror

              </div>

              <div class="form-floating mb-4 text-dark">
                <input type="password" id="password_confirmation" name="password_confirmation" class="form-control  @error('password_confirmation') is-invalid @enderror" placeholder="Konfirmasi Password" required>
                <label for="password_confirmation"><i class="bi bi-shield-lock-fill me-2"></i>Konfirmasi Password</label>
                @error('password_confirmation')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror

              </div>

              {{-- <select class="form-control" name="divisi_id" id="divisi" required>
                  <option value="" selected disabled>Pilih Divisi</option>
                  @foreach ($divisis as $divisi)
                      <option value="{{ $divisi->id }}">{{ $divisi->divisi }}</option>
                  @endforeach
              </select> --}}

              <button class="btn btn-primary btn-lg w-100 mt-4" type="submit">
                <i class="bi bi-person-check-fill me-1"></i>Register
              </button>
            </form>


            <p class="text-center mt-4 mb-0">Sudah punya akun?
              <a href="{{ url('/') }}" class="text-info fw-bold text-decoration-none">Masuk</a>
            </p>

          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>