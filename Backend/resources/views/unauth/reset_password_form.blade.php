@extends('unauth.layout.index')
@section('content')

@error('message')
   <script>
      Swal.fire({
      icon: 'error',
      title: 'Oops...',
      text: @json($message),
      });
   </script>
@enderror
@if(session('success'))
   <script>
      Swal.fire({
         icon: 'success',
         title: 'Success',
         text: @json(session('success')),
      });
   </script>
@endif

<div class="container py-5 h-100">
   <div class="row d-flex justify-content-center align-items-center h-100">
      <div class="col-xl-10">
         <div class="card rounded-3 text-black">
            <div class="row g-0">
               <div class="col-lg-6">
                  <div class="card-body p-md-5 mx-md-4">
                     <div class="text-center">
                        <!--<img src="{{ asset('assets/images/bit-blockdigital_images/logomain.png') }}"-->
                           style="width: 185px;" alt="logo">
                        {{-- <h4 class="mt-1 mb-5 pb-1">We are The Lotus Team</h4> --}}
                     </div>
                     @if(session('success'))
                     <div class="alert alert-success">
                        {{ session('success') }}
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
                     <form action="{{ route('reset_password_user') }}" method="POST">
                        @csrf
                        <input type="hidden" name="token" value="{{ $token }}">
                        <p>Reset Password</p>
                        <div class="form-outline mb-4">
                           <label class="form-label" for="form2Example22">New Password</label>
                           <input type="password" id="form2Example22" name="password" class="form-control" value="{{ old('email') }}"/>
                        </div>

                        <div class="form-outline mb-4">
                            <label class="form-label" for="form2Example22">Confirm Password</label>
                            <input type="password" id="form2Example22" name="password_confirmation" class="form-control" value="{{ old('email') }}"/>
                        </div>


                        <input type="submit" value="Get Started" class="btn btn-outline-danger">
                     </form>
                  </div>
               </div>
            </div>
         </div>
      </div>
   </div>
</div>
@endsection