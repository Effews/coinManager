<!DOCTYPE HTML>

<html>
    <head>
        <meta charset="UTF-8">
        <title>CoinManager</title>
    </head>

    <body>
    <x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                           
        <div id="transacoes" id="teste">
            @foreach ($transacoes as $transacao)
            <div class="transacao" id="{{$transacao->cd_transacao}}"> 
                <p>{{$transacao->cd_transacao}}</p> 
            </div>
            @endforeach
        </div>

        <div>
            <form name="formTransacao">
                @csrf
                <select id="coinType" name="coinType">
                    @foreach ($coins as $coin)
                    <option value="{{$coin->cd_coin}}"> {{$coin->nm_coin}} </option>
                    @endforeach
                </select>

                <select id="fiatType" name="fiatType">
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
            </div>
        </div>
    </div>
</x-app-layout>

        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.form/4.3.0/jquery.form.min.js"></script>

        <script>
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
                            console.log('teste');
                            Object.keys(response.retorno).forEach(function(item) {
                                x = $('#transacoes').children().last().attr('id');

                                if (response.retorno[item].cd_transacao > x) {
                                    t.append('<div class="transacao" id="' + response.retorno[item].cd_transacao + '">' + " codigo " + response.retorno[item].cd_transacao + " Valor " + response.retorno[item].vl_fiat + '</div>') //terminar for pra percorrer tudo e att
                                }
                            });
                        }
                    });
                });
            });
        </script>
    </body>
</html>