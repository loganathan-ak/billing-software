
<x-layout>

<!-- component -->
<div class="bg-sky-100 flex justify-center items-center h-screen">
    <!-- Left: Image -->
<div class="w-1/2 h-screen hidden lg:block">
  <img src="https://img.freepik.com/fotos-premium/imagen-fondo_910766-187.jpg?w=826" alt="Placeholder Image" class="object-cover w-full h-full">
</div>
<!-- Right: Login Form -->
<div class= "lg:p-36 md:p-52 sm:20 p-8 w-full lg:w-1/2">

    @if(Session::has('access'))
    <p class="bg-green-100 text-green-800 text-sm font-medium px-4 py-3 rounded-lg shadow-md">
        {{ session('access') }}
    </p>
    @elseif(Session::has('error'))
    <p class="bg-red-100 text-red-800 text-sm font-medium px-4 py-3 rounded-lg shadow-md">
        {{ session('error') }}
    </p>
    @endif

@if($errors->any())
    <ul class="bg-red-100 text-red-800 text-sm font-medium px-4 py-3 rounded-lg shadow-md mt-4 list-disc pl-5">
        @foreach($errors->all() as $error)
            <li>{{ $error }}</li>
        @endforeach
    </ul>
@endif



  <h1 class="text-2xl font-semibold mb-4">Login</h1>
  <form action="{{route('login')}}" method="POST">

    @csrf
    <!-- Username Input -->
    <div class="mb-4 bg-sky-100">
      <label for="name" class="block text-gray-600">Username</label>
      <input type="text" id="name" name="name" class="w-full border border-gray-300 rounded-md py-2 px-3 focus:outline-none focus:border-blue-500" >
    </div>
    <!-- Password Input -->
    <div class="mb-4">
      <label for="password" class="block text-gray-800">Password</label>
      <input type="password" id="password" name="password" class="w-full border border-gray-300 rounded-md py-2 px-3 focus:outline-none focus:border-blue-500" >
    </div>

    <!-- Login Button -->
    <button type="submit" class="bg-red-500 hover:bg-blue-600 text-white font-semibold rounded-md py-2 px-4 w-full">Login</button>
  </form>
  <!-- Sign up  Link -->
  {{-- <div class="mt-6 text-green-500 text-center">
    <a href="{{route('register')}}" class="hover:underline">Sign up Here</a>
  </div> --}}
</div>
</div>

</x-layout>