@extends('commonUser.layout.appLogado')
@section('content')


<!--colocar na pagina que o resulta vem da api da binance
-->


<div class="container">
  <div class="d-flex justify-content-center">
    <div class="card-cot">
      <div class="card-header">
        <h3>Cotação</h3>
      </div>
      <div class="card-body">
        <form action=" " name="teste">
          <div class="input-group form-group">
            <div class="input-group-prepend">
              <span class="input-group-text icon-cot"><i class="fab fa-bitcoin preto"></i></span>
            </div>
            <select class="form-control cot" id="coinName" placeholder='Nome Moeda' name="coins">
              <option value="none" disabled select>Selecione a moeda</option>
              @foreach ($coins as $coin)
              <option value="{{$coin->sg_coin}}"> {{$coin->sg_coin}} </option>
              @endforeach
            </select>
          </div>
        </form>
        <div id="transacoes" name="transacoes" class="row d-flex justify-content-center">
          <label for="coinname" class="form-label labelColor2">Valor em tempo real: </label>
        </div>
        <p for="fonte" class="fonte justify-content-center d-flex">Dados extraidos pela Binance.</a></p>
      </div>
    </div>
  </div>
  <div class="row">
    <div class="col">
    </div>
    <div class="col">
      <div class='mb-3'>
      </div>
    </div>
    <div class="col">
    </div>
  </div>
</div>

<script>
  $(function() {
    $('#coinName').change(function(event) {
      event.preventDefault();
      $.ajax({
        url: "/priceCoin/" + document.getElementById("coinName").value,
        type: "GET",
        data: {},
        dataType: 'json',
        success: function(response) {
          var t = $('#transacoes');
          $('#valorMoeda').remove()
          t.append(' <p id="valorMoeda" class="labelColor">' + response.toLocaleString('pt-br', {
            style: 'currency',
            currency: 'BRL'
          }) + '</p>')
        }
      });
    });
  });

  $(document).ready(function() {
    var ajaxCall = function() {
      $.ajax({
        url: "/priceCoin/" + document.getElementById("coinName").value,
        type: "GET",
        data: {},
        dataType: 'json',
        success: function(response) {
          var t = $('#transacoes');
          $('#valorMoeda').remove()
          t.append(' <p id="valorMoeda" class="labelColor">' + response.toLocaleString('pt-br', {
            style: 'currency',
            currency: 'BRL'
          }) + '</p>')
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
<section class="footer">

    <h1 class="credit-index"> Desenvolvido por <span> Igor Oliveira, Leonardo Freitas, Marlon Santos </span> | Todos os direitos reservados! </h1>

</section>


@endsection