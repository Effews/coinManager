@extends('commonUser.layout.appLogado')
@section('content')
<php 
    $listCoins 
?>
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


<div class="col-12">
    <div id="transacoes" name="transacoes" class="row">
        @foreach ($transacoes as $transacao)
        <div class="transacao" id="{{$transacao->cd_transacao}}">
            <div class="infos">
                <p class="{{$transacao->sg_coin}}">{{$transacao->sg_coin}} </label>
                <div class="inlineContainerleft">
                    <p> Moedas compradas: {{$transacao->qtd_virtual_coin}} </p>
                    fewfew
                    <p> Val un pago R$:  </p>
                    <p class="valorCompra">Total investido: {{$transacao->vl_fiat }} </p>
                </div>
                <div class="inlineContainerRight">    
                    <p class="valorCompra">Valorização un: </p>
                    <p> Valorização de: valor%</p>
                    <p> Total atual R$: </p>
                </div>
            </div>
            <div>
                <button type="button" class="btn btn-dark btn-lg btn-block ">Retirada</button>
            </div>
        </div>
        @endforeach
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
                        $.ajax({
                        url: "http://coinmanager.com/coinPrice/"+response.retorno[0].cd_transacao,
                        type: "GET",
                        data: {},
                        dataType: 'json',
                        success: function(response2) {
                            var t = $('#transacoes');
                            Object.keys(response.retorno).forEach(function(item) { 
                                t.prepend('<div class="transacao" id=' + response.retorno[item].cd_transacao + '>' +
                                '<div class="infos">' + '<p class="' + response.retorno[item].sg_coin + '" > ' + response.retorno[item].sg_coin + ' </p>' + 
                                '<div class="inlineContainerLeft">' +
                                '<p> Moedas compradas: ' + response.retorno[item].qtd_virtual_coin + '</p>' +
                                '<p class="valorCompra">Valor un pago R$: ' + response2['fiatValorUn'] + '</p>' +
                                '<p class="valorCompra">Total Investido R$: ' + response2['valorInvestido'] + '</p></div>' +
                                ' <div class="inlineContainerRight">' +
                                '<p> Valorização un R$: ' + response2['valorizacaoUnitaria'] + '</p>' +
                                '<p> Valorização de: ' + response2['percentValorizacao'] + '%</p>' +
                                '<p> Total atual R$: ' + response2['fiatValorizacao'] + '</p></div>' +
                                '<div> <button type="button" class="btn btn-dark btn-lg btn-block ">Retirada</button> </div></div>'
                                )
                            });
                        },
                    });
                }
            });
        });
    });
</script>

@endsection