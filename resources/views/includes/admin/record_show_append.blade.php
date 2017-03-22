<div class="row clearfix">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <div class="card">
            <div class="header">
                <h2>
                    Created At
                </h2>
            </div>
            <div class="body">
                <p class="lead">
                    @if(isset($columnsValues['created_at']) && $columnsValues['created_at'])
                        {{$columnsValues['created_at']}}
                    @else
                        Not Set
                    @endif
                </p>
            </div>
        </div>
    </div>
</div>

<div class="row clearfix">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <div class="card">
            <div class="header">
                <h2>
                    Updated At
                </h2>
            </div>
            <div class="body">
                <p class="lead">
                    @if(isset($columnsValues['updated_at']) && $columnsValues['updated_at'])
                        {{$columnsValues['updated_at']}}
                    @else
                        Not Set
                    @endif
                </p>
            </div>
        </div>
    </div>
</div>