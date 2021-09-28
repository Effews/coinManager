@extends('commonUser.layout.app')
@section('content')
<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <a class="navbar-brand" href="#">CoinManager</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav"
        aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav mr-auto">
            <li class="nav-item">
                <a class="nav-link" href="{{ route('login') }}">Entrar</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{ route('register') }}">Cadastre-se</a>
            </li>
        </ul>
    </div>
</nav>

<div class="img-banner">
    <div class="container">
        <div class="row d-flex align-items-end" style="height: 500px;">
            <div class="col-12 mb-5 text-center">
                <h2 class="text-white">Another example headline</h2>
                <h3 class="text-white">
                    Some representative placeholder content for the second slide of the carousel.
                </h3>
            </div>
        </div>
    </div>
</div>
<br> 
<div class="container marketing">
<div class="row">
    <div class="col-lg-4">
      <img class="rounded-circle" src="data:image/gif;base64,R0lGODlhAQABAIAAAHd3dwAAACH5BAAAAAAALAAAAAABAAEAAAICRAEAOw==" alt="Generic placeholder image" width="140" height="140">
      <h2>Heading</h2>
      <p>Donec sed odio dui. Etiam porta sem malesuada magna mollis euismod. Nullam id dolor id nibh ultricies vehicula ut id elit. Morbi leo risus, porta ac consectetur ac, vestibulum at eros. Praesent commodo cursus magna.</p>
      <p>
    </div><!-- /.col-lg-4 -->
    <div class="col-lg-4">
      <img class="rounded-circle" src="data:image/gif;base64,R0lGODlhAQABAIAAAHd3dwAAACH5BAAAAAAALAAAAAABAAEAAAICRAEAOw==" alt="Generic placeholder image" width="140" height="140">
      <h2>Heading</h2>
      <p>Duis mollis, est non commodo luctus, nisi erat porttitor ligula, eget lacinia odio sem nec elit. Cras mattis consectetur purus sit amet fermentum. Fusce dapibus, tellus ac cursus commodo, tortor mauris condimentum nibh.</p>
      <p>
    </div><!-- /.col-lg-4 -->
    <div class="col-lg-4">
      <img class="rounded-circle" src="data:image/gif;base64,R0lGODlhAQABAIAAAHd3dwAAACH5BAAAAAAALAAAAAABAAEAAAICRAEAOw==" alt="Generic placeholder image" width="140" height="140">
      <h2>Heading</h2>
      <p>Donec sed odio dui. Cras justo odio, dapibus ac facilisis in, egestas eget quam. Vestibulum id ligula porta felis euismod semper. Fusce dapibus, tellus ac cursus commodo, tortor mauris condimentum nibh, ut fermentum massa justo sit amet risus.</p>
      <p>
    </div><!-- /.col-lg-4 -->
  </div>
</div>

<div class="container">
    <footer class="py-3 my-4">
      <!-- <ul class="nav justify-content-center border-bottom pb-3 mb-3">
        <li class="nav-item"><a href="#" class="nav-link px-2 text-muted">Home</a></li>
        <li class="nav-item"><a href="#" class="nav-link px-2 text-muted">Features</a></li>
        <li class="nav-item"><a href="#" class="nav-link px-2 text-muted">Pricing</a></li>
        <li class="nav-item"><a href="#" class="nav-link px-2 text-muted">FAQs</a></li>
        <li class="nav-item"><a href="#" class="nav-link px-2 text-muted">About</a></li>
      </ul> -->
      <p class="text-center text-muted">©
           <?php echo date("Y"); ?> CoinManager
        </p>
    </footer>
  </div>
@endsection