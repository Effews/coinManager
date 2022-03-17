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
        <form action=" " name= "teste">
            <select class="form-control" id="coinName" placeholder='Nome Moeda' name="coins" >
              <option value="none" disabled select >Selecione a moeda</option>
              @foreach ($coins as $coin)
              <option value="{{$coin->sg_coin}}"> {{$coin->sg_coin}} </option>
              @endforeach
            </select>
            <br>
            <input class='btn btn-primary'type="submit" value="Submit">
        </form> 
    </div>
    </div>
    <div class="col">
      <div id="transacoes" name="transacoes" class="row">
        <label for="coinname" class="form-label">Valor em tempo real: </label>

        <br>
      </div>
    </div>
  </div>
</div>

<script>
      $(function() {
        $('#coinName').change(function(event) {
            event.preventDefault();
            $.ajax({
                url: "http://coinmanager.com/priceCoin/"+document.getElementById("coinName").value,
                type: "GET",
                data:  {},
                dataType: 'json',
                success: function(response) {
                    var t = $('#transacoes');
                    $('#valorMoeda').remove()
                    t.append('<p id="valorMoeda">' + response.toFixed(2) + '</p>')
                }
            });
        });
    });

    $(document).ready(function() {
      var ajaxCall = function() {
      $.ajax({
        url: "http://coinmanager.com/priceCoin/"+document.getElementById("coinName").value,
        type: "GET",
        data:  {},
        dataType: 'json',
        success: function(response) {
          var t = $('#transacoes');
          $('#valorMoeda').remove()
          t.append('<p id="valorMoeda">' + response.toFixed(2) + '</p>')
        }
      });
  }
  setInterval(ajaxCall, 3000);
});

    //   $(function() {
    //     $('#coinName').change(function(event) {
    //         event.preventDefault();
    //         $.ajax({
    //             url: "http://coinmanager.com/priceCoin/"+document.getElementById("coinName").value,
    //             type: "GET",
    //             data:  {},
    //             dataType: 'json',
    //             success: function(response) {
    //                 var t = $('#transacoes');
    //                 $('#valorMoeda').remove()
    //                 t.append('<p id="valorMoeda">' + response.toFixed(2) + '</p>')
    //             }
    //         });
    //     });
    // });


</script>


@endsection