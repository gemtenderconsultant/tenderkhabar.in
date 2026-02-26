<form action="{{ $PAYU_BASE_URL }}" method="post" name="payuForm">
    <input type="hidden" name="key" value="{{ $MERCHANT_KEY }}">
    <input type="hidden" name="txnid" value="{{ $txnid }}">
    <input type="hidden" name="amount" value="{{ $amount }}">
    <input type="hidden" name="productinfo" value="{{ $productinfo }}">
    <input type="hidden" name="firstname" value="{{ $firstname }}">
    <input type="hidden" name="email" value="{{ $email }}">
    <input type="hidden" name="phone" value="{{ $phone }}">
    <input type="hidden" name="udf1" value="{{ $udf1 }}">
    <input type="hidden" name="udf2" value="{{ $udf2 }}">
    <input type="hidden" name="surl" value="{{ route('payu.success') }}">
    <input type="hidden" name="furl" value="{{ route('payu.failed') }}">
    <input type="hidden" name="hash" value="{{ $hash }}">
    <input type="hidden" name="service_provider" value="payu_paisa">
    
</form>

<script>
    document.payuForm.submit();
</script>

<button type="submit" form="payuForm">If not redirected, click here (or debug only)</button>