<button type="submit" class="btn btn-primary waves-effect">{{$formType}} Record</button>
@if($formType == 'Update')
    <button onclick="window.location.href='{{$modelIndexUrl . 'create'}}'" type="button"
            class="btn btn-primary waves-effect">Add New Record
    </button>
@endif
<button type="reset" class="btn btn-primary waves-effect">Reset</button>
<button onclick="window.location.href='{{$modelIndexUrl}}'" type="button"
        class="btn btn-primary waves-effect">Cancel
</button>