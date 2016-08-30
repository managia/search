@extends('layouts.app')

@section('content')
<script>
    var config = <?= $config ?>;
</script>
<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1" ng-controller="SearchController">
            <div class="page-header">
                <h1>
                    Search page
                </h1>
            </div>
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
