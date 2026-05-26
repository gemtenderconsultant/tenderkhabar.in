<h3>Payment Successful ✅</h3>

@if(!empty($tender->documentpath))
    <iframe
        src="{{ $tender->documentpath }}"
        width="100%"
        height="700"
        style="border:none;">
    </iframe>
@endif