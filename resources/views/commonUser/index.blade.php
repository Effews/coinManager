<h1> registros </h1>

    <div id="transacao">
    @foreach ($transacoes as $transacao)
        <p> {{$transacao->cd_transacao}} </p>
    @endforeach
    </div>

<!-- action= method="post" -->
<form name='formTransacao'>
    @csrf
    <select id="coinType" name="coinType" >
        @foreach ($coins as $coin)
            <option value="{{$coin->cd_coin}}" > {{$coin->nm_coin}} </option>
        @endforeach
    </select>

    <select id="fiatType" name="fiatType" >
        @foreach ($fiats as $fiat)
            <option value="{{$fiat->cd_fiat}}" > {{$fiat->sg_fiat}} </option>
        @endforeach
    </select>

    <input type="text" name="valorFiat" title="valorFiat" id="valorFiat" placeholder="Valor de custo">
    <input type="text" name="qtdVirtualCoin" title="qtdVirtualCoin" id="qtdVirtualCoin" placeholder="Quantidade de moedas compradas">

    <button type="submit">Enviar</button>

</form>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.form/4.3.0/jquery.form.min.js"></script>

<script>
    $(function(){
        $('form[name="formTransacao"]').submit(function(event){
            event.preventDefault();
            
            $.ajax({
                url: "{{ route('transaction.create') }}",
                type: "post",
                data: $(this).serialize(),
                dataType: 'json',
                success: function(response){
                   var t = $('#transacao');
                   t.append('<p>' + response.retorno[2].cd_transacao+ '<p>') //terminar for pra percorrer tudo e att
                }
            });
        });
    });
</script>
