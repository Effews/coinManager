@extends('commonUser.layout.appLogado')
@section('content')

<div class="col-12">
    <div id="transacoes" name="transacoes" class="row">
        @foreach ($transacoes as $transacao)
        <div class="transacao" id="{{$transacao->cd_transacao}}">
            <div class="infos">
                <div class="inlineContainerleft">
                    <p class="{{$transacao->sg_coin}}" >{{$transacao->sg_coin}} </label>
                    <p onload=""> Val un R$: </p>
                    <p> Total atual R$: </p>
                </div>
                <div class="inlineContainerRight">
                    <p> Moedas compradas: {{$transacao->qtd_virtual_coin}} </p>
                    <p class="valorCompra">Valor un: {{$transacao->vl_fiat  / $transacao->qtd_virtual_coin }} </p>
                    <p class="valorCompra">Valor Total: {{$transacao->vl_fiat }} </p>
                    <p> Valorização em %: </p>
                </div>
            </div>
            <div>
                <button type="button" class="btn btn-dark btn-lg btn-block ">Retirada</button>
            </div>
        </div>
        @endforeach
    </div>

    <div>
        <form name="formTransacao">
            @csrf
            <select id="coinType" name="coinType">
                @foreach ($coins as $coin)
                <option value="{{$coin->cd_coin}}"> {{$coin->sg_coin}} </option>
                @endforeach
            </select>

            <!-- Campo começara a ser utilizado de fato quando forem feitas alterações para trabalhar
            com diversos pares de moedas -->
            <select id="fiatType" name="fiatType" style="display: none;">
                @foreach ($fiats as $fiat)
                <option value="{{$fiat->cd_fiat}}"> {{$fiat->sg_fiat}} </option>
                @endforeach
            </select>

            <input type="text" name="valorFiat" title="valorFiat" id="valorFiat" placeholder="Valor de custo">
            <input type="text" name="qtdVirtualCoin" title="qtdVirtualCoin" id="qtdVirtualCoin" placeholder="Quantidade de moedas compradas">

            <button type="submit">Enviar</button>

        </form>
    </div>
</div>


<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.form/4.3.0/jquery.form.min.js"></script>

<script>
    //isso vai pra um arquivo JS depois
    $(function() {
        $('form[name="formTransacao"]').submit(function(event) {
            event.preventDefault();
            $.ajax({
                url: "{{ route('transaction.create') }}",
                type: "post",
                data: $(this).serialize(),
                dataType: 'json',
                success: function(response) {
                    var t = $('#transacoes');
                    Object.keys(response.retorno).forEach(function(item) {
                        x = $('#transacoes').children().last().attr('id');
                        if (response.retorno[item].cd_transacao > x) {
                            t.append('<div class="transacao" id=' + response.retorno[item].cd_transacao + '>' +
                            '<div class="infos">' + ' <div class="inlineContainerleft">' + 
                            '<p class="'+ response.retorno[item].sg_coin+'" > ' +response.retorno[item].sg_coin+ ' </p>' +
                            '<p> Val un R$:' +response.valorizacao.valorizacaoUnitaria+ '</p>' +
                            '<p> Total atual R$:' +response.valorizacao.fiatValorizacao+ '</p></div>'+
                            '<div class="inlineContainerRight">'+
                            '<p> Moedas compradas:' +response.retorno[item].qtd_virtual_coin+ '</p>'+
                            '<p class="valorCompra">Valor un:' + response.retorno[item].vl_fiat  / response.retorno[item].qtd_virtual_coin + '</p>' +
                            '<p class="valorCompra">Valor Total:' + response.retorno[item].vl_fiat + '</p>' +
                            '<p> Valorização em %:'+ response.valorizacao.percentValorizacao +'</p></div>' +
                            '<div> <button type="button" class="btn btn-dark btn-lg btn-block ">Retirada</button> </div></div>'
                            ) 
                        }
                    });
                }
            });
        });
    });

    $(function() {
        $(document).ready(function(event) {
        
            $.ajax({
              url: "{{ route('transaction.getCoinPrice', ['ADA', 132] ) }}",
              type: "GET",
              data: {},
              dataType: 'json',
              success: function(response){
                console.log(response.fiatValorizacao);
              },
            });
        });
    });

</script>



@endsection

