
    <div class="cards m-4" style="background-color: transparent; height: 90%">
        <div class="card-header d-flex p-0 m-0 mt-2">
            <div class="header-left"></div>
            <div class="header-middle">
                <div><b>{{$header}}</b></div>
            </div>
            <div class="header-right"></div>
        </div>
        <div class="card-body h-100 d-flex p-0 m-0">
            <div class="border-left"></div>
            <div class="content-middle">{{$slot}}</div>
            <div class="border-right"></div>
        </div>
        <div class="card-footer d-flex p-0 m-0">
            <div class="footer-left"></div>
            <div class="footer-middle">{{$footer}}</div>
            <div class="footer-right"></div>
        </div>
    </div>
