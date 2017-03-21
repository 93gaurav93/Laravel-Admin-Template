{{--<a href="#">{{$tblMeta['tableTitle']}}</a>--}}
@if(Auth::user()->level <= $tblMeta['userLevel'])
    <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
        <div class="info-box-4">
            <a href="{{$tblMeta['tableIndexUrl']}}">
                <div class="icon">
                    <i class="material-icons col-purple">view_list</i>
                </div>
                <div class="content">
                    <div class="text">{{$tblMeta['tableTitle']}}</div>
                    <div class="number count-to" data-from="0" data-to="{{$tblMeta['recordsCount']}}" data-speed="1000"
                         data-fresh-interval="20"></div>
                </div>
            </a>
        </div>
    </div>
@endif
