@extends('commonUser.layout.appLogado')
@section('content')

<div class="container">
    <br>
    <br>
    <br>
  <div class="row">
    <div class="col">      
    </div>
    <div class="col">
    <div class='mb-3'> 
        <form action=" ">
            <label for="coinname" class="form-label">Nome da Moeda:</label><br>
            <select class="form-control" placeholder='Nome Moeda' name="coins" >
                <option value="none" disable >Insira a moeda</option>
                <option value="brl">BRL</option>
            </select>
            <br>
            <input class='btn btn-primary'type="submit" value="Submit">
        </form> 
    </div>
    </div>
    <div class="col">
      
    </div>
  </div>
</div>



@endsection