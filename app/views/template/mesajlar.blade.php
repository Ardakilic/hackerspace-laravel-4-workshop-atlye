{{-- başarılı, başarısız mesajları --}}
@if(Session::has('success'))
<div class="alert alert-success">
    <b>{{Session::get('success')}}</b>
</div>
@endif

@if(Session::has('hata'))
<div class="alert alert-danger">
    <b>{{Session::get('hata')}}</b>
</div>
@endif
{{-- başarılı, başarısız mesajları son --}}