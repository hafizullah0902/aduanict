

@if($editComplain->complain_status_id==3)
<div class=" alert alert-warning">
    <strong>Menunggu Pengessahan dari Pengadu</strong>
</div>
@elseif($editComplain->complain_status_id==4)
    <div class=" alert alert-warning">
        <strong>Menunggu Pengesahan dari Helpdesk</strong>
    </div>
@elseif($editComplain->complain_status_id==5)
    <div class=" alert alert-warning">
        Aduan Telahpun Selesai
    </div>
@elseif($editComplain->complain_status_id==7)
    <div class=" alert alert-warning">
        Aduan Telah dihantar untuk Tidakan lanjut
    </div>
@endif