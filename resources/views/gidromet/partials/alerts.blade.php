@if (session('success'))
<div class="alert small alert-success text-center mb-0 py-2">
  {{ session('success') }}
</div>
@endif

@if (session('warning'))
<div class="alert small alert-warning text-center mb-0 py-2">
  {{ session('warning') }}
</div>
@endif

@if ($errors->any())
<div class="alert alert-danger mb-0">
  <ul>
    @foreach ($errors as $error)
    <li>{{ $error }}</li>
    @endforeach
  </ul>
</div>
@endif