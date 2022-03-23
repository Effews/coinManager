@extends('commonUser.layout.appLogado')
@section('content')

<php $listCoins ?>


    <div class="container">
        <div class="row">

            <div class="col-4 d-flex">

                <div class="card-transacao">
                    <div class="card-header">
                        <h3>Transação</h3>
                    </div>
                    <div class="card-body">
                        <form name="formTransacao">
                            @csrf
                            <div class="input-group form-group">

                                <select id="coinType" name="coinType">
                                    @foreach ($coins as $coin)
                                    <option value="{{$coin->cd_coin}}"> {{$coin->sg_coin}} </option>
                                    @endforeach
                                </select>
                                <select id="fiatType" name="fiatType" style="display: none;">
                                    @foreach ($fiats as $fiat)
                                    <option value="{{$fiat->cd_fiat}}"> {{$fiat->sg_fiat}} </option>
                                    @endforeach
                                </select>

                                <input type="text" name="valorFiat" title="valorFiat" id="valorFiat" placeholder="Valor de custo">

                                <input type="text" name="qtdVirtualCoin" title="qtdVirtualCoin" id="qtdVirtualCoin" placeholder="Quantidade de moedas compradas" class="inputTransacao">

                            </div>
                            <div class="form-group justify-content-center d-flex">
                                <button type="submit" class=" submit- btn">Enviar</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>



            <div class="col-8 d-flex">
                <div id="transacoes" name="transacoes" class="row">
                    @foreach ($coinsAppreciation as $transacao)
                    <div class="transacao" id="{{$transacao->codTransac}}">
                        <div class="infos">
                            <p class="{{$transacao->sgCoin}}">{{$transacao->sgCoin}} </label>
                            <div class="inlineContainerleft">
                                <p> Moedas compradas: {{$transacao->qtdVirtualCoin}} </p>
                                <p> Val un pago R$: {{$transacao->fiatValorUn}} </p>
                                <p class="valorCompra">Total investido: {{$transacao->valorInvestido }} </p>
                            </div>
                            <div class="inlineContainerRight">
                                <p class="valorCompra">Valorização un: {{$transacao->valorizacaoUnitaria }} </p>
                                <p> Valorização de: {{$transacao->percentValorizacao}} %</p>
                                <p> Total atual R$: {{$transacao->fiatValorizacao}} </p>
                            </div>
                        </div>
                        <div>
                            <button type="button" class="btn btn-lg btn-block btn_retirada "><a href="{{ route('transaction.withdrawal', $transacao->codTransac) }}">Retirada</a></button>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

    <section class="footer">

        <div class="share">
            <a href="#" class="btnf">facebook</a>
            <a href="#" class="btnf">twitter</a>
            <a href="#" class="btnf">instagram</a>
        </div>

        <h1 class="credit"> Desenvolvido por <span> Igor Oliveira, Leonardo Freitas, Marlon Santos </span> | Todos os direitos reservados! </h1>

    </section>


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
                            url: "http://coinmanager.com/coinPrice/" + response.retorno[0].cd_transacao,
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
                                        '<div> <button type="button" class="btn btn-dark btn-lg btn-block "><a href="http://coinmanager.com/withdrawal/' + response.retorno[0].cd_transacao+'">Retirada <a></button> </div></div>'
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