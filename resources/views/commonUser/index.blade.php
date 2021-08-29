<!DOCTYPE HTML>

<html>
    <head>
        <meta charset="UTF-8">
        <title>CoinManager</title>
        <link href="{{ url(mix('css/main.css')) }}" rel="stylesheet" type="text/css">
    </head>

    <body>
        <div>
        <div class="relative flex items-top justify-center min-h-screen bg-gray-100 dark:bg-gray-900 sm:items-center py-4 sm:pt-0">
            @if (Route::has('login'))
                <div class="hidden fixed top-0 right-0 px-6 py-4 sm:block">
                    @auth
                        <a href="{{ url('/dashboard') }}" class="text-sm text-gray-700 underline">Dashboard</a>
                    @else
                        <a href="{{ route('login') }}" class="text-sm text-gray-700 underline">Log in</a>

                        @if (Route::has('register'))
                            <a href="{{ route('register') }}" class="ml-4 text-sm text-gray-700 underline">Register</a>
                        @endif
                    @endauth
                </div>
            @endif
        </div>
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

                            Object.keys(response.retorno).forEach(function(item) {
                                x = $('#transacoes').children().last().attr('id');


                                if (response.retorno[item].cd_transacao > x) {

                                    t.append('<div class="transacao" id="' + response.retorno[item].cd_transacao + '">' + " Valor " + response.retorno[item].cd_transacao + " Valor " + response.retorno[item].vl_fiat + '</div>') //terminar for pra percorrer tudo e att
                                }
                            });
                        }
                    });
                });
            });
        </script>
    </body>

</html>