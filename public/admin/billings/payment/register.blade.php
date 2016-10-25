@if(isset($result_code) && isset($user_id) && $result_code == 1 && $user_id > 0)
    <register-payment-response>
        <result>
            <code>1</code>
            <desc>OK</desc>
        </result>
    </register-payment-response>
@else
    <register-payment-response>
        <result>
            <code>2</code>
            <desc>Temporary unavailable</desc>
        </result>
    </register-payment-response>
@endif
