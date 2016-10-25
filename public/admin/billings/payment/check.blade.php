<payment-avail-response>
    <result>
        <code>1</code>
        <desc>OK</desc>
    </result>
    <merchant-trx>{{$bank->merchant_trx}}</merchant-trx>
    <purchase>
        <shortDesc>{{$bank->short_desc}}</shortDesc>
        <longDesc>{{$bank->long_desc}}</longDesc>
        <account-amount>
            <id>{{$bank->account_id}}</id>
            <amount>{{ $amount }}</amount>
            <currency>{{$bank->currency}}</currency>
            <exponent>{{$bank->exponent}}</exponent>
        </account-amount>
    </purchase>
</payment-avail-response>