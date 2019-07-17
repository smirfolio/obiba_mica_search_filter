<div>
    <form class="filter-name-search-widget">
        <div class="form-group">
            <label for="variablesName">Filter by name variables: </label>
            <textarea class="form-control" rows="5" id="variablesName" ng-model="namesVar"></textarea>
        </div>
        <div class="pull-right voffset2 hoffset2">
            <small><a class="btn btn-info"  ng-href="{{urlRebuildLink()}}">
                {{ 'submit' | translate }}
            </a></small>
        </div>
    </form>
</div>