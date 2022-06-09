@extends('commonUser.layout.appLogado')
@section('content')

<php $listCoins ?>

    <div class="container">
        <div class="row">

            <div class="col-4 d-flex">

                <div class="card-transacao">
                    <div class="card-header">
                        <h3>Transação</h3>
                        <p class="datetime">Dados atualizados em: {{date('H:i:s')}}</p>
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
                                <button type="submit" class="submit-btn glow-button">Enviar</button>
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
                            <p class="moeda {{$transacao->sgCoin}}">{{$transacao->sgCoin}} </label>
                            <div class="inlineContainerleft">
                                <p> Moedas compradas: {{$transacao->qtdVirtualCoin}} </p>
                                <p> Valor unitário pago R$: {{$transacao->fiatValorUn}} </p>
                                <p class="valorCompra">Total investido: R${{$transacao->valorInvestido }} </p>
                                <p class="valorCompra">Valorização unitária: R${{$transacao->valorizacaoUnitaria }} </p>
                                <p> Valorização de: {{$transacao->percentValorizacao}} %</p>
                                <p> Total atual R$: {{$transacao->fiatValorizacao}} </p>
                            </div>
                        </div>
                        <div>
                        <a href="{{ route('transaction.withdrawal', $transacao->codTransac) }}"> <button type="button" class="btn btn_retirada glow-button">Retirada</button></a>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
        <div class="flex justify-center" id="teste">
            {{ $coinsAppreciation->links() }}
        </div>
    </div>


    <section class="footer">
        <h1 class="credit-index"> Desenvolvido por <span> Igor Oliveira, Leonardo Freitas, Marlon Santos </span> | Todos os direitos reservados! </h1>
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
                            url: "/coinPrice/" + response.retorno[0].cd_transacao,
                            type: "GET",
                            data: {},
                            dataType: 'json',
                            success: function(response2) {
                                var t = $('#transacoes');
                                Object.keys(response.retorno).forEach(function(item) {
                                    t.prepend('<div class="transacao" id=' + response.retorno[item].cd_transacao + '>' +
                                        '<div class="infos">' +
                                        '<p class="moeda' + response.retorno[item].sg_coin + '" > ' + response.retorno[item].sg_coin + ' </p>' +
                                        '<div class="inlineContainerLeft">' +
                                        '<p> Moedas compradas: ' + response.retorno[item].qtd_virtual_coin + '</p>' +
                                        '<p class="valorCompra">Valor unitário pago R$: ' + response2['fiatValorUn'] + '</p>' +
                                        '<p class="valorCompra">Total Investido R$: ' + response2['valorInvestido'] + '</p>' +
                                        '<p> Valorização unitária R$: ' + response2['valorizacaoUnitaria'] + '</p>' +
                                        '<p> Valorização de: ' + response2['percentValorizacao'] + '%</p>' +
                                        '<p> Total atual R$: ' + response2['fiatValorizacao'] + '</p></div>' +
                                        '<div> <a href="/withdrawal/' + response.retorno[0].cd_transacao + '"><button type="button" class="btn btn_retirada glow-button">Retirada </button> <a></div></div>'
                                    )
                                    if (document.querySelectorAll('#transacoes button').length + 1 >= 8) {
                                        const element = document.getElementById('transacoes').children[8].id;
                                        $('#' + element).remove();
                                    }

                                    var paginations = document.getElementById("teste");

                                    if (paginations.firstChildtrim == "" || paginations.firstChildtrim == undefined || paginations.firstChildtrim == " " && document.querySelectorAll('#transacoes button').length == 8){
                                        location.reload();
                                    }
                                });
                            },
                        });
                    }
                });
            });
        });
    </script>


    @endsection