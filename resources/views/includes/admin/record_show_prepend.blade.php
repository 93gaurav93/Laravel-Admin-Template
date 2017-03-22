<div class="row clearfix">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <div class="card">
            <div class="header">
                <h2>
                    Id
                </h2>
            </div>
            <div class="body">
                <p class="lead">
                    @if(isset($columnsValues['id']) && $columnsValues['id'])
                        {{$columnsValues['id']}}
                    @else
                        Not Set
                    @endif
                </p>
            </div>
        </div>
    </div>
</div>