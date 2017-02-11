@extends('layouts.app')

@section('content')
<script>
    var config = <?= $config ?>;
</script>
<div class="container">
            <div class="page-header">
                <h1>
                    Search page
                </h1>
            </div>
    <div class="row" ng-controller="SearchController">
        <div class="col-md-3">
            <h4>popular answers</h4>
            @include('popular')
        </div>
        <div class="col-md-9">
            <flash-message></flash-message>
            <nav class="navbar navbar-default" role="navigation">
                <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                    <form class="navbar-form navbar-left" role="search" name="searchForm">
                        <div class="form-group">
                            <?=
                            Form::select('categories', $categories, $category, [
                                'ng-model' => "categories",
                            ])
                            ?>
                        </div>
                        <div class="form-group">
                            <input
                                class="form-control"
                                ng-model="keywords"
                                name="keywords"
                                type="text"
                                placeholder="Enter search string"
                                autocomplete="off"
                                value="<?= $keyword ?>"/>
                        </div> 
                        <button type="submit" class="btn btn-default" ng-click="search()">
                            Search
                        </button>
                    </form>
                </div>
            </nav>
            @include('listgroup')
        </div>
    </div>
</div>
@endsection
